<?php
return [
    'settings' => [
        'debug' => getenv('APP_DEBUG'),
        'addContentLengthHeader' => true,
        'displayErrorDetails' => getenv('APP_DEBUG'),
        'logger.stream' => realpath(sprintf('%s/../logs/%s.log', __DIR__, date('Y-m-d'))),
        'logger.level' => getenv('APP_DEBUG') ? \Monolog\Logger::DEBUG : \Monolog\Logger::ERROR,
        'form.theme' => [
            'bootstrap_4_horizontal_layout.html.twig'
        ],
        'views.paths' => [
            realpath(__DIR__ . '/../views'),
            realpath(__DIR__ . '/../../vendor/symfony/twig-bridge/Resources/views/Form')
        ],
        'views.options' => [
            'auto_reload' => true,
            'debug' => getenv('APP_DEBUG'),
            'cache' => getenv('APP_DEBUG') ? realpath(__DIR__ . '/../cache') : false
        ]
    ],
    'view' => function($c) {

        $router = $c->get('router');
        $uri = $c->get('request')->getUri();
        $paths = $c->get('settings')->get('views.paths');
        $settings = $c->get('settings')->get('views.options');

        $view = new \Slim\Views\Twig($paths, $settings);

        $theme = $c->get('settings')->get('form.theme');

        $engine = new Symfony\Bridge\Twig\Form\TwigRendererEngine($theme, $view->getEnvironment());

        $view->getEnvironment()->addRuntimeLoader(new \Twig\RuntimeLoader\FactoryRuntimeLoader([
                \Symfony\Component\Form\FormRenderer::class => function() use ($engine) {
                    return new \Symfony\Component\Form\FormRenderer($engine);
                }
        ]));

        $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));
        $view->addExtension(new Symfony\Bridge\Twig\Extension\FormExtension());
        $view->addExtension(new \Symfony\Bridge\Twig\Extension\CsrfExtension());
        $view->addExtension(new Symfony\Bridge\Twig\Extension\TranslationExtension());

        return $view;
    },
    'logger' => function($c) {

        $level = $c['settings']['logger.level'];
        $stream = realpath($c['settings']['logger.stream']);

        $logger = new \Monolog\Logger('APP');
        $logger->pushHandler(new \Monolog\Handler\StreamHandler($stream, $level));

        return $logger;
    },
    'entity_manager' => function($c) {

        $paths = realpath(__DIR__ . '/src');
        $connection = ['driver' => getenv('DB_DRIVER'), 'url' => getenv('DB_URL')];

        $config = Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration([$paths], true);

        return \Doctrine\ORM\EntityManager::create($connection, $config);
    },
    'phpmailer' => function($c) {

        $mail = new PHPMailer\PHPMailer\PHPMailer(true);

        $mail->SMTPDebug = 3;
        $mail->isSMTP();
        $mail->Host = getenv('SMTP_SERVER');
        $mail->SMTPAuth = true;
        $mail->Username = getenv('SMTP_USERNAME');
        $mail->Password = getenv('SMTP_PASSWORD');
        $mail->SMTPSecure = 'tls';
        $mail->Port = getenv('SMTP_PORT');

        return $mail;
    },
    'swiftmailer' => function($c) {
        
        $transport = (new Swift_SmtpTransport(getenv('SMTP_SERVER'), getenv('SMTP_PORT')))
            ->setUsername(getenv("SMTP_USERNAME"))
            ->setPassword(getenv('SMTP_PASSWORD'));
        
        return new Swift_Mailer($transport);
    }
];
