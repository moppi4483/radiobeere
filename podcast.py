#!/usr/bin/env python
# -*- coding: utf8 -*-

import MySQLdb
from contextlib import closing
import socket
from email.utils import formatdate
import datetime
import time
import sys
import os

import login


PODCAST_IMG_PATH = '/var/www/img/podcast/'
PODCAST_PATH = '/var/www/podcast/'


def get_baseurl(connection):

    with closing(connection.cursor()) as cursor:
        cursor.execute(
                'SELECT wert FROM settings WHERE name="Protokoll"'
        )
        row = cursor.fetchone()
        prot = row[0]
        if prot != 'https':
            prot = 'http'
        
        
        cursor.execute(
                'SELECT wert FROM settings WHERE name="FQDN"'
        )
        row = cursor.fetchone()
        fqdn = row[0]
        if fqdn == '':
            fqdn = socket.gethostname()
        
        
        base_url = prot + '://' + fqdn
        
        return base_url
    

def get_station_name(connection, station_alias):

    with closing(connection.cursor()) as cursor:
        cursor.execute(
                'SELECT name FROM sender WHERE alias=%s', (
                station_alias,)
        )
        row = cursor.fetchone()
        
        return row[0]


def get_podcast_img(station_alias, hostname):

    podcast_img = PODCAST_IMG_PATH + station_alias + '.jpg'
    if os.path.isfile(podcast_img) is False:
        podcast_img = hostname + '/img/podcast/' + 'default.jpg'
    else:
        podcast_img = hostname + '/img/podcast/' + station_alias + '.jpg'

    return podcast_img


def create_podcast_header(station, last_build_date, podcast_img, hostname):

    podcast_header = [
                    '<?xml version=\"1.0\" encoding=\"UTF-8\"?>',
                    '<rss xmlns:itunes=\"http://www.itunes.com/'
                    + 'dtds/podcast-1.0.dtd\" version=\"2.0\">',
                    '<channel>',
                    '<title>RadioBeere - '
                    + station
                    + '</title>',
                    '<link>'
                    + hostname
                    + '</link>',
                    '<description>Hier hörst du alle Sendungen, die du mit'
                    + ' der RadioBeere aufgenommen hast.</description>',
                    '<language>de-de</language>',
                    '<pubDate>'
                    + last_build_date
                    + '</pubDate>',
                    '<lastBuildDate>'
                    + last_build_date
                    + '</lastBuildDate>',
                    '<generator>RadioBeere</generator>',
                    '<category>Society &amp; Culture</category>',
                    '<image>',
                    '<url>'
                    + podcast_img
                    + '</url>',
                    '<title>RadioBeere - '
                    + station
                    + '</title>',
                    '<link>'
                    + hostname
                    + '</link>',
                    '</image>',
                    '<itunes:subtitle>Hören, wann du willst!'
                    + '</itunes:subtitle>',
                    '<itunes:author>'
                    + station
                    + '</itunes:author>',
                    '<itunes:summary>Hier hörst du alle Sendungen, die du '
                    + 'mit der RadioBeere aufgenommen hast.</itunes:summary>',
                    '<itunes:image href=\"'
                    + podcast_img
                    + '\" />',
                    '<itunes:category text=\"Society &amp; Culture\" />',
                    '\n'
                    ]

    podcast_header = '\n'.join(podcast_header)

    return podcast_header


def create_podcast_item(title, audio_file, length_bytes, guid,
                        pub_date, podcast_img, station, length, hostname):

    podcast_item = [
                    '<item>',
                    '<title>'
                    + title
                    + '</title>',
                    '<link>'
                    + hostname
                    + '/Aufnahmen/'
                    + audio_file
                    + '</link>',
                    '<description>Aufgenommen mit der RadioBeere.'
                    + '</description>',
                    '<enclosure url=\"'
                    + hostname
                    + '/Aufnahmen/'
                    + audio_file
                    + '\" length=\"'
                    + str(length_bytes)
                    + '\" type=\"audio/mpeg\" />',
                    '<guid isPermaLink=\"false\">'
                    + guid
                    + '</guid>',
                    '<pubDate>'
                    + pub_date
                    + '</pubDate>',
                    '<image>',
                    '<url>'
                    + podcast_img
                    + '</url>',
                    '<title>RadioBeere - '
                    + station
                    + '</title>',
                    '<link>'
                    + hostname
                    + '</link>',
                    '</image>',
                    '<itunes:author>'
                    + station
                    + '</itunes:author>',
                    '<itunes:subtitle>Hören, wann du willst!'
                    + '</itunes:subtitle>',
                    '<itunes:image href=\"'
                    + podcast_img
                    + '\" />',
                    '<itunes:duration>'
                    + length
                    + '</itunes:duration>',
                    '</item>',
                    '\n'
                    ]

    podcast_item = '\n'.join(podcast_item)

    return podcast_item


def main():

    with closing(MySQLdb.connect(
            login.DB_HOST, login.DB_USER,
            login.DB_PASSWORD, login.DB_DATABASE)) as connection:

        station_alias = sys.argv[1]
        hostname = get_baseurl(connection)

        station = get_station_name(connection, station_alias)
        last_build_date = formatdate(time.time(), True)
        podcast_img = get_podcast_img(station_alias, hostname)
        xml_file = PODCAST_PATH + station_alias + '.xml'

        feed = open(xml_file, 'w')
        podcast_header = create_podcast_header(
                station, last_build_date, podcast_img,hostname)
        feed.write(podcast_header)
        feed.close

        feed = open(xml_file, 'a')

        with closing(connection.cursor()) as cursor:
            cursor.execute(
                    'SELECT * FROM aufnahmen WHERE sender=%s', (station,))
            result = cursor.fetchall()
            for db_record in result:

                recording_time = datetime.datetime.fromtimestamp(db_record[5])

                podcast_item = create_podcast_item(
                                    '{0}, {1:%d.%m.%Y, %H:%M} Uhr'.format(
                                    station, recording_time),
                                    db_record[4],
                                    db_record[7],
                                    hostname
                                    + '/podcast/'
                                    + station_alias
                                    + '_'
                                    + str(db_record[0]),
                                    db_record[8],
                                    podcast_img,
                                    station,
                                    db_record[6],
                                    hostname
                                    )

                feed.write(podcast_item)

        feed.write('</channel>\n</rss>')

        feed.close


if __name__ == '__main__':
    main()
