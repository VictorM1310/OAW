/** Add RSS Feed */
const addRSSFeedForm = document.getElementById('addRSSFeedForm');

addRSSFeedForm.addEventListener('submit', function (e) {
  e.preventDefault();
  const formData = new FormData(e.target);
  const rssFeedUrl = formData.get('url');
  addRSSFeed(rssFeedUrl);
});

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

const renderRSSFeed = ({ id, title, description }) => {
  let rssFeedBox = `
    <div class="col-md-6 mt-2 ps-3 pe-3">
        <div class="card text-dark bg-light mb-3 text-center rounded-bottom" style="border:none">
            <div class="card-header text-white rounded-top" style="background:#246180 outline:none">
                ${title}
            </div>
            <div class="card-body">
                <p class="card-text">${description}</p>
                <a onclick="saveSelectedRssFeedId(${id})" class="btn btn-outline-dark" href="news.html">Check this feed</a>
            </div>
        </div>
    </div>`;
  const container = document.getElementById('rssFeedContainer');
  container.insertAdjacentHTML('beforeend', rssFeedBox);
};

const saveSelectedRssFeedId = (rssFeedId) => {
  sessionStorage.setItem('id', rssFeedId);
};

(function () {
  fetchFeeds();
})();
