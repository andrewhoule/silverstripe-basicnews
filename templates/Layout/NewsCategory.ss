<h1 class="news-category-title">$NewsCategory.Title<span> News</span></h1>
<% if NewsCategory.Description %>
	<div class="news-category-description">
		$NewsCategory.Description
	</div><!-- news-category-description -->
<% end_if %>
<% if PaginatedNews %>
	<% include NewsExcerpts %>
<% end_if %>
<% if PaginatedNews.MoreThanOnePage %>
    <% include NewsPagination %>
<% end_if %>