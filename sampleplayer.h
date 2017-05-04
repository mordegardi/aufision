#pragma once

#include <QtWidgets>
#include <QtMultimedia>
#include "mediaplaylistmodel.h"

class SamplePlayer : public QWidget
{
    Q_OBJECT

public:
    SamplePlayer(QWidget *parent = 0);

private:
    QMediaPlayer *player;
    QMediaPlaylist *playlist;
    MediaPlaylistModel *playlistModel;
    QAbstractItemView *playlistView;
    QSlider *slider;
    QLabel *labelDuration;
    qint64 duration;
    QMenuBar *menuBar;
    QMenu *fileMenu;
    QMenu *aboutMenu;
    QLabel *trackInfo;
    QLabel *albumInfo;
    QLabel *authorInfo;

    void addToPlaylist(QUrl url);

private slots:
    void open();
    void jump(const QModelIndex &index);
    void seek(int seconds);
    void metaDataChanged();
    void playlistPositionChanged(int);
    void durationChanged(qint64);
    void updateDurationInfo(qint64);
    void positionChanged(qint64);
    void aboutQt();

};
