<?php

namespace Tivins\Assets\Components;

use Tivins\Assets\Components;
use Tivins\Assets\Interfaces\IComment;

class CommentList
{
    /** @var CommentData[] */
    private array $rootComments = [];

    public function addComments(CommentData ...$commentData): static
    {
        $this->rootComments = array_merge($this->rootComments, $commentData);
        return $this;
    }

    public function __toString(): string
    {
        $html = '';
        foreach ($this->rootComments as $comment) {
            $html .= new Comment($comment);
            if ($comment->hasReplies()) {
                $commentsHTML = array_map(fn(IComment $reply) => new Comment($reply), $comment->getReplies());
                $html .= Components::div('comment-replies', join($commentsHTML));
            }
        }
        return $html;
    }
}