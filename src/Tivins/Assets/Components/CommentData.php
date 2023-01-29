<?php

namespace Tivins\Assets\Components;

class CommentData
{

    public int    $timestamp;
    public string $body;
    public string $author;
    public int    $id;
    /**
     * @var CommentData[]
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

    public function hasReplies(): bool {
        return !empty($this->replies);
    }
    public function getReplies(): array
    {
        return $this->replies;
    }

    public function addReplies(CommentData ...$replies): static
    {
        $this->replies = array_merge($this->replies, $replies);
        return $this;
    }

    /**
     * @param int $replyOf
     * @return CommentData
     */
    public function setReplyOf(int $replyOf): CommentData
    {
        $this->replyOf = $replyOf;
        return $this;
    }

    public function isReply(): bool
    {
        return !empty($this->replyOf);
    }
    public function getReplyOf(): int
    {
        return $this->replyOf;
    }

}