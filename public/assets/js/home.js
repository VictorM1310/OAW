const addRSSFeedForm = document.getElementById('addRSSFeedForm');

window.onload = () => {
  fetchFeeds();
};

addRSSFeedForm.addEventListener('submit', function (e) {
  e.preventDefault();
  const formData = new FormData(e.target);
  const rssFeedUrl = formData.get('url');
  addRSSFeed(rssFeedUrl);
});

/** Add RSS Feed */
const addRSSFeed = (rssFeedUrl) => {
  fetch(`./../app/add_or_get_rss_feed.php?url=${rssFeedUrl}`)
    .then((data) => data.json())
    .then(() => setInterval('location.reload()', 100));
};

/** Fetch and render RSS Feeds */
const fetchFeeds = () => {
  fetch('./../app/get_all_rss_feeds.php')
    .then((data) => data.json())
    .then(renderRSSFeeds);
};

const renderRSSFeeds = (rssFeeds) => {
  rssFeeds.forEach(renderRSSFeed);
};

const renderRSSFeed = (rssFeed) => {
  const rssFeedBox = generateRssFeedBox(rssFeed);
  insertRssFeedIntoDOM(rssFeedBox);
  addListenerToNewlyAddedRssFeedBox(rssFeed.id);
};

const insertRssFeedIntoDOM = (rssFeed) => {
  const container = document.getElementById('rssFeedContainer');
  container.insertAdjacentHTML('beforeend', rssFeed);
};

const addListenerToNewlyAddedRssFeedBox = (id) => {
  const rssFeedCheckButton = document.querySelector(`[data-id="${id}"]`);
  rssFeedCheckButton.addEventListener('click', (e) => {
    const clickedRssFeedId = e.target.dataset.id;
    saveSelectedRssFeedId(clickedRssFeedId);
  });
};

const generateRssFeedBox = ({ id, title, description }) => {
  return `
<div class="col-md-6 mt-2 ps-3 pe-3">
  <div class="card text-dark bg-light mb-3 text-center rounded-bottom border-0">
    <div class="card-header text-white rounded-top bg-dark-blue">
      ${title}
    </div>
    <div class="card-body">
      <p class="card-text">
        ${description}
      </p>
      <a class="btn btn-outline-dark" href="news.html" data-id="${id}">
      Check this feed
      </a>
    </div>
  </div>
</div>`;
};

const saveSelectedRssFeedId = (rssFeedId) => {
  sessionStorage.setItem('id', rssFeedId);
};
