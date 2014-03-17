<?php

/*
 * (c) Kristoffer Paulsson <krillzip@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

?>
\documentclass[a4paper,11pt,twoside]{report}
\usepackage[top=15mm,left=20mm,right=52mm,bottom=15mm]{geometry}
\usepackage{multicol}
\usepackage[T1,T2A]{fontenc}
\usepackage[utf8]{inputenc}

\DeclareUnicodeCharacter{00A0}{ }

<?php if( isset($variables['title'])): ?>
\title{<?php echo $variables['title']; ?>}
<?php endif; ?>
<?php if( isset($variables['author'])): ?>
\author{<?php echo $variables['author']; ?>}
<?php endif; ?>

\makeatletter
 \renewcommand\section{\@startsection {section}{1}{\z@}%
     {-2.5ex \@plus -1ex \@minus -.2ex}%
     {1.3ex \@plus.2ex}%
    {\bfseries\centering}}

\begin{document}
<?php if( isset($settings['frontpage']) && ($settings['frontpage'] == false) ): ?><?php else: ?>
\begin{titlepage}
  \newgeometry{margin=25mm}
  <?php if( isset($variables['title'])): ?>
  \maketitle
  <?php endif; ?>
  \newpage
  \thispagestyle{empty}
  \mbox{}
\end{titlepage}
<?php endif; ?>

\scriptsize
\raggedright
\setcounter{secnumdepth}{0}

<?php if( isset($settings['tableOfContent']) && ($settings['tableOfContent'] == false) ): ?><?php else: ?>
\tableofcontents
\newpage
<?php endif; ?>

<?php foreach($collection as $passage): ?>
<?php $chapter = 0; ?>
\section[<?php 
    echo $passage->book.' '.trim(substr($passage->reference, strrpos($passage->reference, ' '))); 
    ?>]{\textmd{{\normalsize <?php 
    echo $passage->title ? $passage->title : $passage->book.' '.trim(substr($passage->reference, strrpos($passage->reference, ' '))); 
    ?>}<?php if($passage->title): ?>\\{\scriptsize <?php
    echo $passage->book.' '.trim(substr($passage->reference, strrpos($passage->reference, ' '))); 
    ?>}<?php endif; ?>}}

\begin{multicols}{2}
\noindent <?php foreach($passage->verseCollection as $vIndex => $verse): ?>\textsuperscript{<?php
if($verse['chapter'] != $chapter){
    $chapter = $verse['chapter'];
    echo $verse['chapter'].':'.$verse['verse'];
}else{
    echo $verse['verse'];   
}
?>} <?php echo $verse['text']; ?><?php if($vIndex < (count($passage->verseCollection)-1)): ?>\linebreak
<?php endif; ?>
<?php endforeach; ?>

\end{multicols}
<?php endforeach; ?>
\end{document}