const jsdom = require('jsdom');
const fs = require('fs');
const { JSDOM } = jsdom;

const templates = [
  { template: 'public/home.html', outputFile: 'webpack/templates/home.html' },
  { template: 'public/news.html', outputFile: 'webpack/templates/news.html' },
];

const processHtmlPage = (html) => {
  const dom = new JSDOM(html);
  removeDevScriptTags(dom);
  removeDevLinkTags(dom);
  return dom;
};

const removeDevScriptTags = (dom) => {
  const scriptTags = dom.window.document.querySelectorAll('script');
  scriptTags.forEach((scriptTag) => {
    const scriptSrc = scriptTag.src;
    if (scriptSrc.includes('assets')) {
      scriptTag.remove();
    }
  });
};

const removeDevLinkTags = (dom) => {
  const linkTags = dom.window.document.querySelectorAll('link');
  linkTags.forEach((linkTag) => {
    const linkHref = linkTag.href;
    if (linkHref.includes('assets')) {
      linkTag.remove();
    }
  });
};

const writeProcessedDom = (processedDom, outputFile) => {
  const html = extractHTMLFromProcessedDOM(processedDom);
  fs.writeFileSync(outputFile, html, 'utf-8');
};

const extractHTMLFromProcessedDOM = (processedDom) => {
  const outerHtml = processedDom.window.document.documentElement.outerHTML;
  return '<!DOCTYPE html>' + '\n' + outerHtml;
};

try {
  templates.forEach(({ template, outputFile }) => {
    const html = fs.readFileSync(template, 'utf8');
    const processedDom = processHtmlPage(html);
    writeProcessedDom(processedDom, outputFile);
  });
} catch (err) {
  console.error(err);
}
