// import LoadMore from "./loadMore"
// import DISCO_FilterablePostList from "./filterablePostList"

// export default [LoadMore, DISCO_FilterablePostList]

// Frontend js of FilterablePostList module
$(function(){
    $('[class*="-category-list"]').hide();	
})	

function filterPosts(category){
    $('.disco-active-list').fadeOut(500);
    $(`.disco-${category}-category-list`).fadeIn(500);
    $('.disco-active-list').removeClass('disco-active-list');
    $(`.disco-${category}-category-list`).addClass('disco-active-list');
}

function handleLoadMorePosts(e){
    let page = e.target.dataset.page
    let category = e.target.dataset.list === 'latest' ? '' : e.target.dataset.list

    $.ajax({
        url: siteConfig?.ajaxUrl ?? '',
        method:'post',
        data: {
            action: 'disco_load_more',
            ajax_nonce: siteConfig?.ajax_nonce ?? '',
            page: page,
            category: category
        },
        success: (response) => {
            console.log('New posts!');
            console.log(response);
        },
        error: (response) => {
            console.log('Error');
            console.log(response);
            console.log(response.responseText);
        }
    })
}
