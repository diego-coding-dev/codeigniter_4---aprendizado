<?php

namespace Config;

use CodeIgniter\Config\BaseService;

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends BaseService {

    private const SESSION_SERVICE_NAMESPACE = '\App\Libraries\Session\\';
    private const MODEL_SERVICE_NAMESPACE = '\App\Models\\';
    private const ENTITY_SERVICE_NAMESPACE = '\App\Entities\\';
    private const VALIDATION_SERVICE_NAMESPACE = '\App\Validation\\';
    private const AUTH_SERVICE_NAMESPACE = '\App\Libraries\Auth\\';
    private const TOKEN_SERVICE_NAMESPACE = '\App\Libraries\\';
    private const TIME_SERVICE_NAMESPACE = '\CodeIgniter\I18n\\';
    private const EMPLOYEE_EMAIL_SERVICE_NAMESPACE = '\App\Libraries\Email\\';

    /**
     * função para carregar serviço de sessões
     * @param string $sessionClass classe com o serviço de sessão
     * @return object nova instância da classe solicitada
     */
    public static function sessionService(string $sessionClass): object {

        $class = self::SESSION_SERVICE_NAMESPACE . $sessionClass;

        $reflectedClass = new \ReflectionClass($class);

        return $reflectedClass->newInstance();
    }

    /**
     * função para carregar serviço de models
     * @param string $modelClass classe com o serviço de model
     * @param mixed $params parâmetros para o construtor
     * @return object nova instância da classe solicitada
     */
    public static function modelService(string $modelClass): object {

        $class = self::MODEL_SERVICE_NAMESPACE . $modelClass;

        return new $class;
    }

    /**
     * função para carregar serviço de entities
     * @param string $entityClass classe com o serviço de entity
     * @return object nova instância da classe solicitada
     */
    public static function entityService(string $entityClass): object {

        $class = self::ENTITY_SERVICE_NAMESPACE . $entityClass;

        $reflectedClass = new \ReflectionClass($class);

        return $reflectedClass->newInstance();
    }

    /**
     * função para carregar serviço de validações
     * @param string $validationClass classe com o serviço de validação
     * @return object nova instância da classe solicitada
     */
    public static function validationService(string $validationClass): object {

        $class = self::VALIDATION_SERVICE_NAMESPACE . $validationClass;

        $reflectedClass = new \ReflectionClass($class);

        return $reflectedClass->newInstance();
    }

    /**
     * função para carregar serviço de autenticação
     * @param string $authClass classe com o serviço de autenticação
     * @return object nova instância da classe solicitada
     */
    public static function authService(string $authClass): object {

        $class = self::AUTH_SERVICE_NAMESPACE . $authClass;

        $reflectedClass = new \ReflectionClass($class);

        return $reflectedClass->newInstance();
    }

    /**
     * função para carregar serviço de autenticação
     * @param string $tokenClass classe com o serviço de autenticação
     * @param mixed $params parâmetros para o construtor
     * @return object nova instância da classe solicitada
     */
    public static function tokenService(string $tokenClass = null, mixed $params = null): object {

        $class = self::TOKEN_SERVICE_NAMESPACE . ($tokenClass == null ? 'Token' : $tokenClass);

        $reflectedClass = new \ReflectionClass($class);

        return $reflectedClass->newInstance($params);
    }

    /**
     * função para carregar serviço de Time
     * @param string $timeClass classe com o serviço de time/data
     * @param mixed $params parâmetros para o construtor
     * @return object nova instância da classe solicitada
     */
    public static function timeService(string $timeClass = null, mixed $params = null): object {

        $class = self::TIME_SERVICE_NAMESPACE . ($timeClass == null ? 'Time' : $timeClass);

        $reflectedClass = new \ReflectionClass($class);

        return $reflectedClass->newInstance($params);
    }
    
    /**
     * função para carregar serviço de email
     * @param string $emailClass classe com o serviço de email
     * @param mixed $params parâmetros para o construtor
     * @return object nova instância da classe solicitada
     */
    public static function emailService(string $emailClass = null, mixed $params = null): object {

        $class = self::EMPLOYEE_EMAIL_SERVICE_NAMESPACE . ($emailClass == null ? 'Time' : $emailClass);

        $reflectedClass = new \ReflectionClass($class);

        return $reflectedClass->newInstance($params);
    }

}
