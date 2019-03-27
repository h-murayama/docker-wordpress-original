/*
 * ■コンストラクタ関数（オブジェクトの初期化）
 */
function Animation(el) {
    this.initialize(el);
}

/*
 * ■初期化処理
 */
Animation.prototype.initialize = function(el) {
    this.$el = el;
    this.$window = $(window);
    this.$document = $(document);
    this.wd = 0;
    this.wh = 0;
    this.spWidth = 768;
    this.menuFlg = false;
    this.scrollTop = 0;
    this.handleEvents();
}

/*
 * ■イベント検知
 */
Animation.prototype.handleEvents = function () {
    var self = this;

    // ページ読み込み時
    this.$window.on('load', function (e) {
        self.wd = $(window).width();
    });

    // ページリサイズ時
    this.$window.on('resize', function (e) {
        self.wd = $(window).width();
    });

    // 動画再生ボタンクリック時

    this.$document.on('click', '.movieJSFrame', function() {
        var data = $(this).find('.playBtn').data('src');
        var src = "https://www.youtube.com/embed/" + data + "?rel=0&autoplay=1";
        var html = '<iframe width="100%" height="100%" src=' + src + ' frameborder="0" allowfullscreen></iframe><i><img src="/img/movie_close.png" /></i>';
        $('#playMovie').fadeIn('fast');
        $('#movie').html(html);
    });

    // 動画終了ボタンクリック時
    this.$document.on('click', '#playMovie i', function() {
        $('#playMovie').fadeOut('fast'),
        $('#movie').empty()
    });

    // SP ハンバーガーメニュー開閉
    this.$document.on('click', '.spMenu, #spMenuBg', function(event) {
        if (self.wd <= self.spWidth) {
            event.preventDefault();
            if (self.menuFlg == false) {
                self.scrollTop = $(window).scrollTop();
                $('html, body').addClass('prevent');
                $('header, #spMenuBg').addClass('on');
                self.menuFlg = true;
            } else {
                $('html, body').removeClass('prevent').css({'top': 0});
                window.scrollTo(0, self.scrollTop);
                $('header, #spMenuBg').removeClass('on');
                self.menuFlg = false;
            }
        }
    });

    // SP ハンバーガーメニューサブメニュー開閉
    this.$document.on('click', 'header ul.nav li.list .tablink', function(event) {
        if (self.wd <= self.spWidth) {
          event.preventDefault();
          $(this).closest('li').toggleClass('on');
        }
    });

    // SP フッタークリック時サブメニュー開閉
    this.$document.on('click', 'footer ul.linkMenu li .mainLink > a', function(event) {
        if (self.wd <= self.spWidth) {
            if (!$(this).hasClass('footerTop')){
                event.preventDefault();
                $(this).closest('.mainLink').toggleClass('on');
            }
        }
    });
}

/*
 * ■js実行
 */
var animation = new Animation ();