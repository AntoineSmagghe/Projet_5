SC.resolve(" {{sound}} ")
    .then((track) => {
        document.getElementsByClassName("widget_SC")[0].insertAdjacentHTML("beforeend", '<iframe width="100%" height="20" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/' + track.id + '&color=%230e0d26&inverse=true&auto_play=false&show_user=true"></iframe>');
    });