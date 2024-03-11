<?php

namespace NotificationChannels\Ortto\Client;

class TransactionalEmailBuilder
{
    protected string $from_email;
    protected string $from_name;
    protected string $reply_to;
    protected array $cc = [];
    protected string $subject;
    protected string $email_name;
    protected bool $no_click_tracks = false;
    protected bool $no_open_tracks = false;
    protected string $html_body;
    protected bool $liquid_syntax_enabled = false;
    protected array $emails = [];
    protected array $merge_by = [];
    protected int $merge_strategy = 2;
    protected int $find_strategy = 0;
    protected bool $skip_non_existing = false;

    /** @param \Illuminate\Http\Client\PendingRequest $pending_request */
    public function __construct(protected $pending_request)
    {
    }

    public function fromEmail(string $email)
    {
        $this->from_email = $email;
        return $this;
    }

    public function fromName(string $name)
    {
        $this->from_name = $name;
        return $this;
    }

    public function from(string $name, string $email)
    {
        return $this->fromName($name)->fromEmail($email);
    }

    public function replyTo(string $email)
    {
        $this->reply_to = $email;
        return $this;
    }

    public function cc(...$emails)
    {
        $this->cc = array_merge($this->cc, $emails);

        return $this;
    }

    public function subject(string $subject)
    {
        $this->subject = $subject;
        return $this;
    }

    public function emailName(string $email_name)
    {
        $this->email_name = $email_name;
        return $this;
    }

    public function noClickTracks(bool $value = true)
    {
        $this->no_click_tracks = $value;
        return $this;
    }

    public function noOpenTracks(bool $value = true)
    {
        $this->no_open_tracks = $value;
        return $this;
    }

    public function htmlBody(string $html_body)
    {
        $this->html_body = $html_body;
        return $this;
    }

    public function liquidSyntaxEnabled(bool $value = true)
    {
        $this->liquid_syntax_enabled = $value;
        return $this;
    }

    public function emails(...$emails)
    {
        $this->emails = array_merge($this->emails, $emails);
        return $this;
    }

    public function mergeBy(string $key, string $value)
    {
        $this->merge_by[$key] = $value;
        return $this;
    }

    public function mergeStrategy(int $value)
    {
        $this->merge_strategy = $value;
        return $this;
    }

    public function findStrategy(int $value)
    {
        $this->find_strategy = $value;
        return $this;
    }

    public function skipNonExisting(bool $value = true)
    {
        $this->skip_non_existing = $value;
        return $this;
    }

    public function send()
    {
        $response = $this->pending_request
            ->asJson()
            ->acceptsJson()
            ->post("v1/transactional/send", [
                "assets" => [
                    "from_email" => $this->from_email,
                    "from_name" => $this->from_name,
                    "reply_to" => $this->reply_to,
                    "cc" => $this->cc,
                    "subject" => $this->subject,
                    "email_name" => $this->email_name,
                    "no_click_tracks" => $this->no_click_tracks,
                    "no_open_tracks" => $this->no_open_tracks,
                    "html_body" => $this->html_body,
                    "liquid_syntax_enabled" => $this->liquid_syntax_enabled,
                ],
                "emails" => $this->emails,
                "merge_by" => $this->merge_by,
                "merge_strategy" => $this->merge_strategy,
                "find_strategy" => $this->find_strategy,
                "skip_non_existing" => $this->skip_non_existing,
            ]);

        return $response;
    }
}
