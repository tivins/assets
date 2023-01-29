<?php

namespace Tivins\Assets\Structures;

use Tivins\Assets\Box;
use Tivins\Assets\Components;
use Tivins\Assets\LinkList;
use Tivins\Assets\ListItem;

class BlogPost
{
    public function __toString(): string
    {
        $box1 = (new Box())
            // ->setTitle('Article')
            // ->setIcon('fa fa-book')
            // ->setBackURL('/assets')
            ->setHeaderClasses('text-center')
            ->setFooterClasses('no-background')
            ->setFooter('<div class="flex-grow">
            <a href="/assets/modal-user-register.html" class="p-3 d-block text-center w-100 simi-link">
                New here? <span class="simi-react">Create an account</span>.
            </a>
            </div>
          ')
            ->setBodyClasses('p-4 markdown-body')
            ->addHTML($this->getBody());

        $box2 = (new Box())
            ->setTitle('About')
            ->setBodyClasses('p')
            ->addHTML('<div class="subtext-2">Written by</div><div>John Doe</div>
            <div class="subtext"><i class="fa-regular fa-calendar mr-1 op-05"></i>Janvier 1974</div>
            <hr>
            <div class="tag-list">
              <a href="#" class="tag">Quisque</a> <a href="#" class="tag">Donec</a> <a href="#" class="tag">Nullam egestas</a> <a href="#" class="tag">Lorem ipsum</a>
            </div>
        ');


        $linkList = new LinkList();

        $linkList->push(new ListItem(
            title: 'HTML Page template',
            subTitle: 'How to start with assets…<div class="subtext-3">6 comments | 54 views</div>',
            link: '/assets/tpl-page.html',
            icon: 'fa fa-code',
            supTitle: ""
        ));
        $linkList->push(new ListItem(
            title: 'HTML Page template',
            subTitle: 'How to start with assets…',
            link: '/assets/tpl-page.html',
            icon: 'fa fa-chess'
        ));
        $linkList->push(new ListItem(
            title: 'HTML Page template',
            subTitle: 'How to start with assets…',
            link: '/assets/tpl-page.html',
            icon: 'fa fa-chess'
        ));

        $box3 = (new Box())
            ->setTitle('Related')
            ->addHTML($linkList);
        return '
            <div class="d-flex-md gutter">
            <div class="col-8">'.$box1.'</div>
            <div class="col-4">'.$box2.$box3.'</div>
            </div>
        ';
    }
    private function getBody():string {
        return '<h1>Fusce vel tincidunt libero!</h1>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque id erat imperdiet, ullamcorper ligula ut, dapibus tortor. <code>Ut et nisl vel</code> ipsum scelerisque feugiat sit amet id eros.</p>
          <p><b>Quisque laoreet</b>, velit at venenatis pharetra, orci lorem iaculis augue, vel consequat nisl augue sit amet tellus. Curabitur a metus tempus, ultrices risus et, ultrices mauris. Proin tempor ligula at nibh iaculis accumsan. Nulla id lacus semper orci accumsan vestibulum. Aliquam fermentum, magna et feugiat tempor, augue dolor aliquam ipsum, et pharetra turpis purus vitae massa. In a sagittis massa, eu tincidunt ante.</p>
          <blockquote>Suspendisse suscipit purus quis sagittis viverra. Cras facilisis diam sit amet mi viverra pellentesque. Duis a augue in nulla bibendum sollicitudin nec id augue. Curabitur tempus commodo dolor. Integer dapibus interdum ipsum, at aliquet tellus consectetur et. Donec tortor urna, sodales vel nulla nec, convallis hendrerit magna. Integer erat quam, consequat in purus vitae, efficitur tempor enim. </blockquote>
          <div class="box box-info mb"><div class="header p no-borders">Ut ac ante ipsum. Nulla bibendum metus justo, efficitur hendrerit ante rutrum et. Donec nisl nibh, placerat a lobortis sed, congue eget tellus.</div></div>
          <p>Nullam egestas risus magna, non efficitur lacus convallis nec. Donec nisl nibh, placerat a lobortis sed, congue eget tellus. Aliquam porttitor nisi vel eleifend sagittis. Donec at ipsum mattis, varius neque sit amet, auctor magna. In consectetur elit semper tellus laoreet maximus. Vivamus vestibulum condimentum dolor et accumsan. Integer euismod eu sapien id cursus. Phasellus ex sapien, eleifend et sapien quis, lobortis hendrerit odio. Ut eget imperdiet eros. Mauris porta risus eget purus ultrices, vitae lobortis quam luctus. Vestibulum vel elementum quam. Duis purus enim, varius a mattis sed, consequat et ante. Ut vel lacus id orci fermentum semper.</p>
          <p>Nam a augue nunc. Donec volutpat eleifend pulvinar. Ut ac ante ipsum. Nulla bibendum metus justo, efficitur hendrerit ante rutrum et. Suspendisse cursus finibus sodales. Aliquam feugiat interdum dolor, vitae maximus leo efficitur quis. Donec luctus maximus quam, eget euismod ante ullamcorper id. Phasellus interdum, diam consectetur fringilla placerat, nunc libero aliquet tortor, vel mollis mi eros ut libero. Phasellus ut fermentum eros. Cras placerat erat purus, vel maximus ipsum efficitur et.</p>
          <pre><code>for (;;) ;</code></pre>
          <p>Ut nec nibh sit amet ligula sagittis interdum. Nulla tempor dapibus quam quis dapibus. Fusce vel tincidunt libero. Quisque laoreet feugiat accumsan. Pellentesque non felis efficitur, consequat ipsum non, porta nulla. Etiam vitae magna auctor, varius nulla nec, gravida felis. Vivamus accumsan odio nisl, in cursus dolor auctor eu. Maecenas aliquet aliquet sapien, at bibendum dolor tristique et. Vestibulum cursus pharetra nunc, non dictum leo porta eget. Proin pharetra dui nec est congue scelerisque. Aliquam eget ipsum viverra, ornare ante quis, ultrices eros. Duis nisl ante, porttitor in nibh quis, pellentesque gravida eros. In lobortis diam non est consequat fringilla. Integer euismod ligula vitae ex vestibulum tempor.</p>
          <h2>Nulla tempor dapibus quam quis dapibus?</h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque id erat imperdiet, ullamcorper ligula ut, dapibus tortor. Ut et nisl vel ipsum scelerisque feugiat sit amet id eros. Quisque laoreet, velit at venenatis pharetra, orci lorem iaculis augue, vel consequat nisl augue sit amet tellus. Curabitur a metus tempus, ultrices risus et, ultrices mauris. Proin tempor ligula at nibh iaculis accumsan. Nulla id lacus semper orci accumsan vestibulum. Aliquam fermentum, magna et feugiat tempor, augue dolor aliquam ipsum, et pharetra turpis purus vitae massa. In a sagittis massa, eu tincidunt ante. Suspendisse suscipit purus quis sagittis viverra. Cras facilisis diam sit amet mi viverra pellentesque. Duis a augue in nulla bibendum sollicitudin nec id augue. Curabitur tempus commodo dolor. Integer dapibus interdum ipsum, at aliquet tellus consectetur et. Donec tortor urna, sodales vel nulla nec, convallis hendrerit magna. Integer erat quam, consequat in purus vitae, efficitur tempor enim. </p>
          <p>Nullam egestas risus magna, non efficitur lacus convallis nec. Donec nisl nibh, placerat a lobortis sed, congue eget tellus. Aliquam porttitor nisi vel eleifend sagittis. Donec at ipsum mattis, varius neque sit amet, auctor magna. In consectetur elit semper tellus laoreet maximus. Vivamus vestibulum condimentum dolor et accumsan. Integer euismod eu sapien id cursus. Phasellus ex sapien, eleifend et sapien quis, lobortis hendrerit odio. Ut eget imperdiet eros. Mauris porta risus eget purus ultrices, vitae lobortis quam luctus. Vestibulum vel elementum quam. Duis purus enim, varius a mattis sed, consequat et ante. Ut vel lacus id orci fermentum semper.</p>
          <h3>Nulla tempor dapibus quam quis dapibus?</h3>
          <p>Nam a augue nunc. Donec volutpat eleifend pulvinar. Ut ac ante ipsum. Nulla bibendum metus justo, efficitur hendrerit ante rutrum et. Suspendisse cursus finibus sodales. Aliquam feugiat interdum dolor, vitae maximus leo efficitur quis. Donec luctus maximus quam, eget euismod ante ullamcorper id. Phasellus interdum, diam consectetur fringilla placerat, nunc libero aliquet tortor, vel mollis mi eros ut libero. Phasellus ut fermentum eros. Cras placerat erat purus, vel maximus ipsum efficitur et.</p>
          <ul>
          <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
          <li>Quisque id erat imperdiet, ullamcorper ligula ut, dapibus tortor.</li>
          <li>Donec nisl nibh, placerat a lobortis sed, congue eget tellus.</li>
          </ul>
</ul>
          <p>Ut nec nibh sit amet ligula sagittis interdum. Nulla tempor dapibus quam quis dapibus. Fusce vel tincidunt libero. Quisque laoreet feugiat accumsan. Pellentesque non felis efficitur, consequat ipsum non, porta nulla. Etiam vitae magna auctor, varius nulla nec, gravida felis. Vivamus accumsan odio nisl, in cursus dolor auctor eu. Maecenas aliquet aliquet sapien, at bibendum dolor tristique et. Vestibulum cursus pharetra nunc, non dictum leo porta eget. Proin pharetra dui nec est congue scelerisque. Aliquam eget ipsum viverra, ornare ante quis, ultrices eros. Duis nisl ante, porttitor in nibh quis, pellentesque gravida eros. In lobortis diam non est consequat fringilla. Integer euismod ligula vitae ex vestibulum tempor.</p>
          
          ';
    }
}