(window.webpackJsonp=window.webpackJsonp||[]).push([[4],{3:function(t,o,n){t.exports=n("XR3o")},XR3o:function(t,o){$(function(){$(".bookmark-story").on("click",function(t){var o=$(this),a=o.data("story-id"),r=o.data("bookmarked"),k=c(),i={story_id:a},s="⚫",u=!0;t.preventDefault(),r&&(k=e(),i=Object.assign({},i,{_method:"DELETE"}),s="⚪️",u=!1),$.ajax({method:"post",url:k,data:i}).done(n(a,s,u))})});var n=function(t,o,n){return function(){var a,r,e;a=n?1:-1,r=$("#bookmark-count"),e=1*r.text(),r.text(e+a),$('.bookmark-story[data-story-id="'.concat(t,'"]')).each(function(){var t=$(this);t.text(o),t.data("bookmarked",n)})}};var a,r,e=function(){return a||(a=$('meta[name="route-hackernews-bookmark-destroy"]').attr("content")),a},c=function(){return r||(r=$('meta[name="route-hackernews-bookmark-destroy"]').attr("content")),r}}},[[3,0]]]);