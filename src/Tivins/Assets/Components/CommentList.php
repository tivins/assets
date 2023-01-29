<?php

namespace Tivins\Assets\Components;

class CommentList
{
    /** @var CommentData[] */
    private array $rootComments = [];

    public function addComment(CommentData $commentData) {
        $this->rootComments[] = $commentData;
    }

    public function __toString(): string
    {
        $html = '';
        foreach ($this->rootComments as $comment) {
            $html .= new Comment($comment);
            if ($comment->hasReplies()) {
                $html .= '<div class="comment-replies">';
                foreach ($comment->getReplies() as $reply) {
                    $html .= new Comment($reply);
                }
                $html .= '</div>';
            }
        }
        return $html;
    }
}