const selectedRssFeedId = sessionStorage.getItem('id');

/** Fetch current selected RSS Feed news */
const fetchFeeds = () => {
  const defaultField = 'pubDate';
  const defaultOrder = 'asc';
  clearRSSFeeds();
  fetch(
    `./../app/get_news_ordered_by.php?` +
      `id=${selectedRssFeedId}&` +
      `field=${defaultField}&` +
      `sort_order=${defaultOrder}`
  )
    .then((data) => data.json())
    .then(renderNews);
};

const clearRSSFeeds = () => {
  const container = document.getElementById('newsContainer');
  container.innerHTML = '';
};

const renderNews = (news) => {
  news.forEach(renderIndividualNews);
};

const renderIndividualNews = ({
  title,
  description,
  categories,
  pubDate,
  url,
}) => {
  let newsBox = `
    <div class="col-md-6 mt-2 ps-3 pe-3">
        <div class="card text-dark bg-light mb-3 text-center rounded-bottom" style="border:none">
            <div class="card-header text-white rounded-top" style="background:#246180 outline:none">
                ${title}
            </div>
            <div class="card-body">
                <p class="card-text" style="overflow:hidden">${description} </p>
                <p class="card-text">${categories}</p>
                <p class="card-text">${url}</p>
                <footer><p class="card-text mb-3">${pubDate.date}</p></footer>
                <a class="btn btn-outline-dark" href="${url}">Check the entire news</a>
            </div>
        </div>
    </div>`;
  const container = document.getElementById('newsContainer');
  container.insertAdjacentHTML('beforeend', newsBox);
};

/** Refresh all RSS Feeds */
const refresh = () => {
  clearRSSFeeds();
  fetch(`./../app/update_rss_feeds.php?selected_rss=${selectedRssFeedId}`)
    .then((data) => data.json())
    .then((rssFeed) => renderNews(rssFeed.news));
};

/** Order By */
function orderBy() {
  const field = getSelectedField();
  const orderType = getOrderType();
  clearRSSFeeds();
  fetch(
    `./../app/get_news_ordered_by.php?id=${selectedRssFeedId}&field=${field}&sort_order=${orderType}`
  )
    .then((data) => data.json())
    .then(renderNews);
}

const getSelectedField = () => {
  const orderSelect = document.getElementById('orderSelect');
  const field = orderSelect.value;
  return field;
};

const getOrderType = () => {
  const orderTypeSelect = document.getElementById('orderTypeSelect');
  const orderType = orderTypeSelect.value;
  return orderType;
};

/** Search by title */
const searchByTitle = () => {
  const form = document.getElementById('searchByTitleForm');
  const formData = new FormData(form);
  const title = formData.get('search');
  clearRSSFeeds();
  fetch(
    `./../app/search_rss_news_by_title.php?id=${selectedRssFeedId}&title=${title}`
  )
    .then((data) => data.json())
    .then(renderNews);
};
