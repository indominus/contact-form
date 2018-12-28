<?php
namespace App\Services;

use Slim\Container;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;

class Controller
{

    /**
     *
     * @var Container
     */
    private $container;

    /**
     * 
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }
    
    /**
     * 
     * @return \Slim\Router
     */
    public function getRouter()
    {
        return $this->container->get('router');
    }

    /**
     * 
     * @return \PHPMailer
     */
    public function getPHPMailer()
    {
        return $this->container->get('phpmailer');
    }
    
    /**
     * 
     * @return \Swift_Mailer
     */
    public function getSwiftMailer()
    {
        return $this->container->get('swiftmailer');
    }
    
    /**
     * 
     * @return \Symfony\Component\Form\FormFactoryInterface
     */
    public function getFormFactory()
    {
        return \Symfony\Component\Form\Forms::createFormFactoryBuilder()
            ->addExtension(new ValidatorExtension(Validation::createValidator()))
            ->getFormFactory();
    }

    /**
     * 
     * @return \Doctrine\ORM\EntityManagerInterface
     */
    public function getEntityManager()
    {
        return $this->container->get('entity_manager');
    }

    /**
     * 
     * @param string $template
     * @param array $args
     * 
     * @return mixed
     */
    public function display($template, array $args = [])
    {
        return $this->container->get('view')->render($this->container->get('response'), $template, $args);
    }
}
