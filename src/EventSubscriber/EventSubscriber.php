<?php

namespace App\EventSubscriber;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\File;

class EventSubscriber implements EventSubscriberInterface
{


    public function __construct(private readonly MailerInterface $mailerInterface)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            # send mails orden
            'api.executed.send_mail_orden' => 'onsendOrdenEmails',
        ];
    }

    // TEMPLATES
    //
    // confirm_orden
    // confirmation_anulation_orden
    // create_orden
    // send_invoice
    // send_orden
    public function onsendOrdenEmails(GenericEvent $event): void
    {
        $params = $event->getSubject();

        try {

            $this->sendEmail($params);

        } catch (\Exception $ex) {
        }
    }

    private function sendEmail(array $params): void
    {
        try {

            $email = (new TemplatedEmail())
                ->from(new Address($_SERVER['EMAIL_FROM']))
                ->to(new Address($params['email_to']))
                ->subject($params['subject'])
                ->priority(Email::PRIORITY_HIGH)
                // path of the Twig template to render
                ->htmlTemplate('emails/'.$params['template'].'.html.twig')
                // pass variables (name => value) to the template
                ->context($params);

            if (isset($params['add_part_file'])) {

                $file = $params['add_part_file'];
                $email
                    ->addPart(
                        new DataPart(new File($file), basename($file), 'application/pdf')
                    );
            }

            $this->mailerInterface->send($email);

        } catch (\Exception|TransportExceptionInterface $exception) {
            dd($exception);
        }

    }
}