<div class="news-meta-wrap">
    <p class="meta"><% if Author %><span>by</span> $Author <% end_if %> <span>on</span> $NiceDate</p>
    <% if NewsCategories %>
        <p class="categories">
            <span>Posted in: </span>
            <% loop NewsCategories %>
                <a href="$Link">$Title</a><% if Last %><% else %>, <% end_if %>
            <% end_loop %>
        </p>
    <% end_if %>
</div><!-- news-meta-wrap -->