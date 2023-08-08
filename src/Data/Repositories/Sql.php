<?php

namespace PragmaRX\Tracker\Data\Repositories;

use PragmaRX\Support\Config;

class Sql extends Repository
{
    private $queries = [];

    /**
     * @var SqlQueryLog
     */
    private $SqlQueryLogRepository;

    /**
     * @var SqlBinding
     */
    private $SqlBindingRepository;

    /**
     * @var SqlBindingParameter
     */
    private $SqlBindingParameterRepository;

    /**
     * @var Connection
     */
    private $connectionRepository;

    /**
     * @var Log
     */
    private $logRepository;

    /**
     * @var \PragmaRX\Support\Config
     */
    private $config;

    public function __construct(
        $model,
        SqlQueryLog $SqlQueryLogRepository,
        SqlBinding $SqlBindingRepository,
        SqlBindingParameter $SqlBindingParameterRepository,
        Connection $connectionRepository,
        Log $logRepository,
        Config $config
    ) {
        parent::__construct($model);

        $this->SqlQueryLogRepository = $SqlQueryLogRepository;

        $this->SqlBindingRepository = $SqlBindingRepository;

        $this->SqlBindingParameterRepository = $SqlBindingParameterRepository;

        $this->connectionRepository = $connectionRepository;

        $this->logRepository = $logRepository;

        $this->config = $config;
    }

    public function fire()
    {
        if (!$this->logRepository->getCurrentLogId()) {
            return;
        }

        foreach ($this->queries as $query) {
            $this->logQuery($query);
        }

        $this->clear();
    }

    private function SqlIsLoggable($Sql)
    {
        return strpos($Sql, '"tracker_') === false;
    }

    private function serializeBindings($bindings)
    {
        return serialize($bindings);
    }

    public function push($query)
    {
        $this->queries[] = $query;

        $this->fire();
    }

    private function logQuery($query)
    {
        $Sql = htmlentities($query['query']);

        $bindings = $query['bindings'];

        $time = $query['time'];

        $name = $query['name'];

        if (!$this->SqlIsLoggable($Sql)) {
            return;
        }

        $connectionId = $this->connectionRepository->findOrCreate(
            ['name' => $name],
            ['name']
        );

        $SqlId = $this->findOrCreate(
            [
                'sha1'          => sha1($Sql),
                'statement'     => $Sql,
                'time'          => $time,
                'connection_id' => $connectionId,
            ],
            ['sha1']
        );

        if ($bindings && $this->canLogBindings()) {
            $bindingsSerialized = $this->serializeBindings($bindings);

            $Sql_bindings_id = $this->SqlBindingRepository->findOrCreate(
                ['sha1' => sha1($bindingsSerialized), 'serialized' => $bindingsSerialized],
                ['sha1'],
                $created
            );

            if ($created) {
                foreach ($bindings as $parameter => $value) {
                    $this->SqlBindingParameterRepository->create(
                        [
                            'sql_query_bindings_id' => $Sql_bindings_id,

                            // unfortunately laravel uses question marks,
                            // but hopefully someday this will change
                            'name'                  => '?',

                            'value'                 => $value,
                        ]
                    );
                }
            }
        }

        $this->SqlQueryLogRepository->create(
            [
                'log_id'       => $this->logRepository->getCurrentLogId(),
                'sql_query_id' => $SqlId,
            ]
        );
    }

    private function canLogBindings()
    {
        return $this->config->get('log_sql_queries_bindings');
    }

    /**
     * @return array
     */
    private function clear()
    {
        return $this->queries = [];
    }
}
