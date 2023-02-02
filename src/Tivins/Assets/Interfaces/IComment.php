<?php

namespace Tivins\Assets\Interfaces;

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
