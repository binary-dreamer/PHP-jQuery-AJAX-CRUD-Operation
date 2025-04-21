<div id="pagination"></div>

<template id="pagination-template">
    <button class="pagination-btn" data-page="{{prevPage}}">< Previous</button>
    <button class="pagination-btn{{activeClass1}}" data-page="{{page1}}">page1</button>
    <button class="pagination-btn{{activeClass2}}" data-page="{{page2}}">page2</button>
    <button class="pagination-btn{{activeClass3}}" data-page="{{page3}}">page3</button>
    <span>...</span>
    <button class="pagination-btn{{activeClassLast}}" data-page="{{lastPage}}">lastPage</button>
    <button class="pagination-btn" data-page="{{nextPage}}">Next ></button>
</template>
