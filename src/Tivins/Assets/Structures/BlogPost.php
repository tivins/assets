<?php

namespace Tivins\Assets\Structures;

use Tivins\Assets\Box;
use Tivins\Assets\Components;
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
            . Components::subText((new Components\Icon('eye', true)) . '24,549 views', 'py-1')
            . Components::subText((new Components\Icon('comment', true)) . '64 comments', 'py-1')
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
                (new Components\Button())
                    ->setIcon(new Components\Icon('eye', true, muted: false) )
                    ->setClasses('ghost flex-grow')
                    ->setTitle('Total of views')
                    ->setLabel(new Str(number_format(Fake::number('m'))))
                . (new Components\Button())
                    ->setIcon(new Components\Icon('star', true, muted: false) )
                    ->setClasses('ghost flex-grow')
                    ->setTitle('Total of star')
                    ->setLabel(new Str(number_format(Fake::number('dk'))))
                . (new Components\Button())
                    ->setIcon(new Components\Icon('heart', true, muted: false) )
                    ->setClasses('ghost flex-grow')
                    ->setTitle('Total of like')
                    ->setLabel(new Str(number_format(Fake::number('k'))))
                . (new Components\Button())
                    ->setIcon(new Components\Icon('comment', true, muted: false) )
                    ->setClasses('ghost flex-grow')
                    ->setTitle('Total of comments')
                    ->setLabel(new Str(number_format(Fake::number('d'))))
                . (new Components\Button())
                    ->setIcon(new Components\Icon('bookmark', true, muted: false) )
                    ->setClasses('ghost flex-grow')
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

        return '<h1>Blog post</h1>'.MicroLayout::col84Gutter($box1
            .'<h3>Author</h3>'.$authorBox
            .'<h3>Comments</h3>'.$boxCom,$box2.$box5.$box3.$box4.$box6);
    }
    private function getBody():string {
        return '<h1>Fusce vel tincidunt libero!</h1>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque id erat imperdiet, ullamcorper ligula ut, dapibus tortor. <code>Ut et nisl vel</code> ipsum scelerisque feugiat sit amet id eros.</p>
          <p><b>Quisque laoreet</b>, velit at venenatis pharetra, orci lorem iaculis augue, vel consequat nisl augue sit amet tellus. Curabitur a metus tempus, ultrices risus et, ultrices mauris. Proin tempor ligula at nibh iaculis accumsan. Nulla id lacus semper orci accumsan vestibulum. Aliquam fermentum, magna et feugiat tempor, augue dolor aliquam ipsum, et pharetra turpis purus vitae massa. In a sagittis massa, eu tincidunt ante.</p>
          <blockquote>'.Fake::paragraph().'</blockquote>
          <div class="box box-info mb"><div class="header p no-borders">'.Fake::sentence(3).'</div></div>
          <p>'.Fake::paragraph().'</p>
          <pre class="highlight"><code><span class="kn">for</span> (;;) ;</code></pre>
          <p>'.Fake::paragraph().'</p>
          <h2>'.trim(Fake::sentence(),'.').'?</h2>
          <p>'.Fake::paragraph().'</p>
          <h3>'.rtrim(Fake::sentence(),'.').'!</h3>
          <p>'.Fake::paragraph().'</p>
          <ul>
          <li>'.Fake::sentence().Components::subText(Fake::sentence()).'</li>
          <li>'.Fake::sentence().Components::subText(Fake::sentence()).'</li>
          <li>'.Fake::sentence().Components::subText(Fake::sentence()).'</li>
          </ul>
          <p>'.Fake::paragraph().'</p>
          ';
    }
}