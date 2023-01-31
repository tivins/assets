<?php

namespace Tivins\Assets\Components;

interface IComment
{
    public function getId(): int;

    public function getAuthor(): string;

    public function getBody(): string;

    public function getTimestamp(): int;

    public function hasReplies(): bool;

    /**
     * @return static[]
     */
    public function getReplies(): array;

    public function isReply(): bool;

    public function getReplyOf(): int;
}
class CommentData implements IComment
{
    private int    $timestamp;
    private string $body;
    private string $author;
    private int    $id;
    /**
     * @var IComment[]
     */
    private array $replies = [];
    private int $replyOf = 0;

    public function __construct(
        string $author,
        string $body,
        int    $timestamp,
        int    $id,
    )
    {
        $this->id        = $id;
        $this->author    = $author;
        $this->body      = $body;
        $this->timestamp = $timestamp;
    }
    public function getId():int{return $this->id;}
    public function getAuthor():string{return $this->author;}
    public function getBody():string{return $this->body;}
    public function getTimestamp():int{return $this->timestamp;}
    public function hasReplies(): bool {
        return !empty($this->replies);
    }
    public function getReplies(): array
    {
        return $this->replies;
    }
    public function isReply(): bool
    {
        return !empty($this->replyOf);
    }
    public function getReplyOf(): int
    {
        return $this->replyOf;
    }
    public function addReplies(IComment ...$replies): static
    {
        $this->replies = array_merge($this->replies, $replies);
        return $this;
    }
    public function setReplyOf(int $replyOf): CommentData
    {
        $this->replyOf = $replyOf;
        return $this;
    }


}