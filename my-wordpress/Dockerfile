FROM wordpress:latest

# 必要なツール郡をインストール
RUN apt-get update
RUN apt-get -y install wget unzip

# WP プラグイン (zip) ダウンロード
WORKDIR /tmp/wp-plugins
RUN wget https://downloads.wordpress.org/plugin/wp-emmet.zi://downloads.wordpress.org/plugin/advanced-custom-fields.5.7.12.zip
RUN wget https://downloads.wordpress.org/plugin/mw-wp-form.4.0.6.zip
RUN wget https://downloads.wordpress.org/plugin/custom-post-type-permalinks.3.3.1.zip
RUN wget https://downloads.wordpress.org/plugin/wp-mail-smtp.1.4.1.zip

# Zip ファイルを解凍してインストール
RUN unzip './*.zip' -d /usr/src/wordpress/wp-content/plugins

# 不要になった一時ファイルを削除
RUN apt-get clean
RUN rm -rf /tmp/*

# サーバが読めるように wp-content 以下の所有者を変更
RUN chown -R www-data:www-data /usr/src/wordpress/wp-content

WORKDIR /var/www/html
