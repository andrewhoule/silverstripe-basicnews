<div class="news-meta">
  <% if $NewsCategories %>
    <div class="news-meta__item">
      <span class="news-meta__label">Posted in: </span>
      <% loop $NewsCategories %>
        <a href="$Link">$Title</a><% if $Last %><% else %>, <% end_if %>
      <% end_loop %>
    </div>
  <% end_if %>
  <div class="news-meta__item">
    <% if $NewsAuthors %>
      <span class="news-meta__label">by</span>
      <% loop $NewsAuthors %>
        <a href="$Link">$FullName</a><% if $Last %><% else %>, <% end_if %>
      <% end_loop %>
    <% end_if %>
    <span>on</span> $NiceDate
  </div>
</div><!-- news-meta -->
