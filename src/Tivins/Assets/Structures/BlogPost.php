<?php

namespace Tivins\Assets\Structures;

use Tivins\Assets\Box;
use Tivins\Assets\Components;
use Tivins\Assets\Components\Button;
use Tivins\Assets\Components\CommentData;
use Tivins\Assets\Components\Timeline;
use Tivins\Assets\Components\TimelineItem;
use Tivins\Assets\Fake;
use Tivins\Assets\LinkList;
use Tivins\Assets\ListItem;
use Tivins\Assets\MicroLayout;
use Tivins\Assets\Str;

class BlogPost
{
    private string $authorName;
    private int $createdAt;
    private array $tags = [];

    public function __construct()
    {
        $this->authorName = Fake::name();
        $this->createdAt = Fake::timestamp();
        $this->tags[] = Fake::words(2);
        $this->tags[] = Fake::words(1);
        $this->tags[] = Fake::words(2);
        $this->tags[] = Fake::words(1);
    }

    public function getAboutBox(): string
    {
        $body = Components::subText2('Written by')
            . Components::div('', new Str($this->authorName))
            . Components::subText(
                (new Components\Icon('calendar', true))
                . date('F Y', $this->createdAt)
            )
            . '<hr>'
            . Components::subText(Components::ico('tags') . 'Tags', 'mb-1')
            . Components::getTagList($this->tags)
            . '<hr>'
            . Components::subText((new Components\Icon('eye', true)) . number_format(Fake::number()).' views', 'py-1')
            . Components::subText((new Components\Icon('comment', true)) . number_format(Fake::number()) . ' comments', 'py-1')
            ;

        return (new Box())
            ->setTitle('About')
            ->setBodyClasses('p')
            ->addHTML($body);
    }

    public function __toString(): string
    {
        $box1 = (new Box())
            ->setHeaderClasses('text-center')
            ->setBodyClasses('p-4 markdown-body')
            ->addHTML($this->getBody())
            ->setFooterClasses('no-background p-1')
            // ->setFooter(
            //     '<div class="p-4 d-block text-center flex-grow simi-link">
            //     <i class="fa-regular fa-2x fa-comment-dots"></i><br>
            //     Public comments are now <b>closed</b>.<br>Only authorized users are
            //     able to write new comments.
            //     </div>
            // ')
            ->setFooter(
                (Button::newGhost())
                    ->setIcon(new Components\Icon('eye', true, mutedLevel: 0) )
                    ->addClasses('flex-grow')
                    ->setTitle('Total of views')
                    ->setLabel(new Str(number_format(Fake::number('m'))))
                . (Button::newGhost())
                    ->setIcon(new Components\Icon('star', true, mutedLevel: 0) )
                    ->addClasses('flex-grow')
                    ->setTitle('Total of star')
                    ->setLabel(new Str(number_format(Fake::number('dk'))))
                . (Button::newGhost())
                    ->setIcon(new Components\Icon('heart', true, mutedLevel: 0) )
                    ->addClasses('flex-grow')
                    ->setTitle('Total of like')
                    ->setLabel(new Str(number_format(Fake::number('k'))))
                . (Button::newGhost())
                    ->setIcon(new Components\Icon('comment', true, mutedLevel: 0) )
                    ->addClasses('flex-grow')
                    ->setTitle('Total of comments')
                    ->setLabel(new Str(number_format(Fake::number('d'))))
                . (Button::newGhost())
                    ->setIcon(new Components\Icon('bookmark', true, mutedLevel: 0) )
                    ->addClasses('ghost flex-grow')
                    ->setTitle('Number of bookmarked')
                    ->setLabel(new Str(number_format(Fake::number('u'))))
            )
            ;

        $commentList = new Components\CommentList();
        for ($i=0;$i<5;$i++) {
            $comment1 = new CommentData(Fake::name(), Fake::paragraph(), Fake::timestamp(), 3546);
            $comment1->addReplies(
                (new CommentData(Fake::name(), Fake::paragraph(), Fake::timestamp(), 3546))
                    ->setReplyOf(3456),
                (new CommentData(Fake::name(), Fake::sentence(), Fake::timestamp(), 3546))
                    ->setReplyOf(3456),
            );
            $commentList->addComment($comment1);
        }


        $boxCom = '<div class="box p-4 d-block text-center flex-grow simi-link mb-3">
                <i class="fa-regular muted-2 fa-2x fa-comment-dots d-block mb-3"></i>
                Public comments are now <b>closed</b>.<br>Only authorized users are
                able to write new comments.
                </div>
            ';
        $boxCom .= $commentList;

        $linkList = new LinkList();

        for ($i = 0; $i < 5; $i++) {
            $linkList->push(
                new ListItem(
                    title: Fake::sentence(),
                    subTitle: Fake::sentence()
                    . Components::subText2(
                        sprintf('%s comments | %s views',
                            number_format(Fake::number()),
                            number_format(Fake::number())
                        )
                    ),
                    link: '/assets/tpl-page.html',
                    icon: '',
                    supTitle: ""
                )
            );
        }
        $linkList2 = new LinkList();
        for ($i = 0; $i < 3; $i++) {
            $linkList2->push(
                new ListItem(
                    title: Fake::sentence(),
                    subTitle: Fake::sentence()
                    . Components::subText2(
                        sprintf('%s comments | %s views',
                            number_format(Fake::number()),
                            number_format(Fake::number())
                        )
                    ),
                    link: '/assets/tpl-page.html',
                    icon: '',
                    supTitle: ''
                )
            );
        }
        $linkList3 = new LinkList();
        for ($i = 0; $i < 2; $i++) {
            $linkList3->push(
                new ListItem(
                    title: Fake::sentence(),
                    subTitle: Fake::sentence()
                    . Components::subText2(
                        sprintf('%s comments | %s views',
                            number_format(Fake::number()),
                            number_format(Fake::number())
                        )
                    ),
                    link: '/assets/tpl-page.html',
                    icon: '',
                    supTitle: ''
                )
            );
        }

        $time = time() - 3600;
        $timeline = new Timeline();
        $timeline->addItem(
            new TimelineItem(
                $time -= rand(3600*24,3600*24*30), 
                Fake::words(4), 
                Fake::sentence()
            )
        );
        $timeline->addItem(
            new TimelineItem(
                $time -= rand(3600*24,3600*24*30), 
                Fake::words(4), 
                Fake::sentence() 
                . '<div class="mt-2">'.(new Components\Button())
                    ->setIcon(new Components\Icon('paper-plane', 'regular'))
                    ->setLabel(new Str('Read newspaper')).'</div>'
            )
        );
        $timeline->addItem(
            new TimelineItem(
                $time -= rand(3600*24,3600*24*30), 
                Fake::words(4), 
                Fake::sentence()
            )
        );

        $box2 = $this->getAboutBox();

        $box3 = (new Box())
            ->setTitle('Related')
            ->addHTML($linkList);
        $box4 = (new Box())
            ->setTitle('Trending')
            ->addHTML($linkList2);
        $box5 = (new Box())
            ->setTitle('Featured')
            ->setBoxClasses('box-info mb')
            ->addHTML($linkList3);
        $box6 = (new Box())
            ->setTitle('Timeline')
            ->addHTML($timeline);

        $authorBox = (new Components\Card($this->authorName, Fake::sentence()));

        return
            new InteractivePath('/blog/2023/assets')
            . MicroLayout::col84Gutter($box1
            .'<h3>Author</h3>'.$authorBox
            .'<h3>Comments</h3>'.$boxCom,$box2.$box5.$box3.$box4.$box6);
    }
    private function getBody():string {
        return '<h1>Fusce vel tincidunt libero!</h1>
          <p>'.Fake::paragraph().'</p>
          <blockquote>'.Fake::sentence(5).'</blockquote>
          <div class="box box-info mb"><div class="header p no-borders">'.Fake::sentence(3).'</div></div>
          <p>'.Fake::paragraph().'</p>
          <pre class="highlight"><code><span class="kn">for</span> (;;) ;</code></pre>
          <p>'.Fake::sentence(3).'</p>
          <h2>'.trim(Fake::sentence(),'.').'?</h2>
          <p>'.Fake::sentence(5).'</p>
          <h3>'.rtrim(Fake::sentence(),'.').'!</h3>
          <p>'.Fake::sentence(3).'</p>
          <ul>
          <li>'.Fake::sentence(1).Components::subText(Fake::sentence(1, .2)).'</li>
          <li>'.Fake::sentence(1).Components::subText(Fake::sentence(1, .5)).'</li>
          <li>'.Fake::sentence(1).Components::subText(Fake::sentence(1, .7)).'</li>
          </ul>
          <p>'.Fake::paragraph().'</p>
          ';
    }
}