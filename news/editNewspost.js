document.addEventListener("DOMContentLoaded", main);

async function main() {
    const params = new Proxy(new URLSearchParams(window.location.search), {
        get: (searchParams, prop) => searchParams.get(prop),
    });

    const newspost = await getNewspost(params.id);

    const post_id_container = document.getElementById('post_id');
    const post_title_container = document.getElementById('post_title');
    const post_text_container = document.getElementById('post_text');

    post_id_container.setAttribute("value", newspost.post_id);
    post_title_container.setAttribute("value", newspost.post_title);
    post_text_container.innerHTML = newspost.post_text.replaceAll("<br/>", "\r\n");
}

async function getNewspost(id) {
    try {
        const response = await fetch(`/api/news?id=${id}`);
        if (!response.ok) {
            throw new Error(`${response.status} ${response.statusText}`);
        }
        const r = await response.json()
        return r;
    }
    catch (error) {
        console.log(error);
    }
}