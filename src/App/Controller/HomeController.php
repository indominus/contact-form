<?php
namespace App\Controller;

use App\Form\ContactForm;
use App\Services\Controller;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HomeController extends Controller
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args = [])
    {

        $form = $this->getFormFactory()
            ->create(ContactForm::class, new \App\Entity\ContactForm(), []);

        $form->handleRequest();

        if ($form->isSubmitted()) {

            if ($form->isValid()) {

                $message = $form->getData();
                $message->setCreatedAt(new \DateTime());

                if ($form->get('swiftmailer')->isClicked()) {
                    $this->sendMessageWithSwiftMailer($message);
                } else if ($form->get('phpmailer')->isClicked()) {
                    $this->sendMessageWithPHPMailer($message);
                }

                $this->getEntityManager()->persist($message);
                $this->getEntityManager()->flush();

                return $response->withRedirect($this->getRouter()->pathFor('homepage'));
            }
        }

        return $this->display('layout.html.twig', ['form' => $form->createView()]);
    }

    /**
     * 
     * @param \App\Entity\ContactForm $message
     * @return \App\Entity\ContactForm
     */
    public function sendMessageWithPHPMailer(\App\Entity\ContactForm $data)
    {

        $data->setType(\App\Entity\ContactForm::TYPE_PHPMAILER);

        /* @var $mailer PHPMailer */
        $mailer = $this->getPHPMailer();
        
        $mailer->isHTML(true);
        $mailer->Subject = $data->getSubject();
        $mailer->Body = $data->getMessage();
        $mailer->setFrom($data->getSender());
        $mailer->addAddress($data->getReceiver());
        
        try {
            $mailer->send();
        } catch (\Exception $ex) {
            $data->setCode($ex->getCode());
            $data->setStatus($ex->getMessage());
        }
        
        return $data;
    }

    /**
     * 
     * @param \App\Entity\ContactForm $message
     * @return \App\Entity\ContactForm
     */
    public function sendMessageWithSwiftMailer(\App\Entity\ContactForm $data)
    {

        $data->setType(\App\Entity\ContactForm::TYPE_SWIFTMAILER);

        $message = (new \Swift_Message($data->getSubject()))
            ->setFrom($data->getSender())
            ->setTo($data->getReceiver())
            ->setBody($data->getMessage());

        try {
            $this->getSwiftMailer()->send($message);
        } catch (\Swift_TransportException $ex) {
            $data->setCode($ex->getCode());
            $data->setStatus($ex->getMessage());
        }

        return $data;
    }
}
