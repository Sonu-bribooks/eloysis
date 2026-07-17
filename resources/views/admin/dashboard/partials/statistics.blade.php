@php

$cards = [

[
'title'=>'Students',
'count'=>$stats['students'],
'icon'=>'bi-people',
'color'=>'primary'
],

[
'title'=>'Teachers',
'count'=>$stats['teachers'],
'icon'=>'bi-person-workspace',
'color'=>'success'
],

[
'title'=>'Classes',
'count'=>$stats['classes'],
'icon'=>'bi-building',
'color'=>'warning'
],

[
'title'=>'Exams',
'count'=>$stats['exams'],
'icon'=>'bi-journal-check',
'color'=>'danger'
],

[
'title'=>'Results',
'count'=>$stats['results'],
'icon'=>'bi-award',
'color'=>'info'
],

[
'title'=>'Subjects',
'count'=>$stats['subjects'],
'icon'=>'bi-book',
'color'=>'secondary'
],

[
'title'=>'Contacts',
'count'=>$stats['contacts'],
'icon'=>'bi-envelope',
'color'=>'dark'
],

[
'title'=>'Admins',
'count'=>$stats['admins'],
'icon'=>'bi-shield-lock',
'color'=>'primary'
]

];

@endphp

@foreach($cards as $card)

<x-ui.stat-card :title="$card['title']" :count="$card['count']" :icon="$card['icon']" :color="$card['color']"/> 

@endforeach