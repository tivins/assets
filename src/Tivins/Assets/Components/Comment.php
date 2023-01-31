<?php

namespace Tivins\Assets\Components;

use Tivins\Assets\Box;
use Tivins\Assets\Components;
use Tivins\Assets\Str;

class Comment extends Box
{
    public function __construct(private CommentData $data)
    {
        $reply = '';
        //$reply .= '<div class="markdown-body mb">
        //    <div class="mb-2">In reply to <a href="#comment-987">comment</a> of John Doe,</div>
        //    <blockquote class="my-2">
        //        Nullam egestas risus magna, non efficitur lacus convallis nec. Donec nisl nibh, placerat a lobortis sed, congue eget tellus :)
        //    </blockquote></div>'
        //;

        //$text = 'Written by';
        //if ($this->data->isReply()) {
        //    $text = (new Icon('turn-up')) . 'Replied by';
        //}
        $this->addHeaderInfo('<span class="subtext p pr-0">'.'by'.'</span>');
        $this->setTitle($this->data->getAuthor());
        $this->addHeaderOption(
            '<div class="header-item muted-2 fs-90">on '
            . '<a href="#comment-' . $this->data->getId() . '">' . date('F jS, Y', $this->data->getTimestamp()) . '</a>'
            . '</div>'
        );
        $this->setBodyClasses('p-3');
        $this->setFooterClasses('no-background p-1');
            $this->setFooter(
                ($this->data->isReply() ?
                    '':
                    '<a href="#" class="px py-2 disabled">' . Components::ico('reply') . 'reply</a>'
                )
                . Components::div('flex-grow', '')
                . (new Button())
                    ->setIcon(new Icon('triangle-exclamation'))
                    ->setLabel(new Str('signaler'))
                    ->setClasses('px py-2 muted-2 fs-90')
                    ->setUrl('#')
            );
        $this->setHTML(Components::div('markdown-body', $this->data->getBody()));
    }
}