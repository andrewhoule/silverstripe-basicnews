<div class="news-meta-wrap">
    <% if NewsCategories %>
        <span class="categories">
            <span>Posted in: </span>
            <% loop NewsCategories %>
                <a href="$Link">$Title</a><% if Last %><% else %>, <% end_if %>
            <% end_loop %>
        </span>
    <% end_if %>
    <span class="meta"><% if Author %><span>by</span> $Author <% end_if %> <span>on</span> $NiceDate</span>
</div><!-- news-meta-wrap -->