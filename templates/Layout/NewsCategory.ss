<% with $NewsCategory %>
  <div class="news-category-meta">
    <h1 class="news-category-title">$Title<span> News</span></h1>
    <% if Description %>
      <div class="news-category-description">
        $Description
      </div><!-- news-category-description -->
    <% end_if %>
  </div><!-- news-category-meta -->
  <% if PaginatedNews %>
    <% include NewsExcerpts %>
  <% end_if %>
  <% if PaginatedNews.MoreThanOnePage %>
      <% include NewsPagination %>
  <% end_if %>
<% end_with %>
  