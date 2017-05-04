#include "sampleplayer.h"
#include "mediaplaylistmodel.h"
#include "mediacontrols.h"
#include <QtWidgets>
#include <QMediaMetaData>
#include <QtMultimedia>

SamplePlayer::SamplePlayer(QWidget *parent)
    : QWidget(parent)
    , slider(0)
{

    player = new QMediaPlayer(this);
    playlist = new QMediaPlaylist();
    player->setPlaylist(playlist);

    connect(player, SIGNAL(durationChanged(qint64)), this, SLOT(durationChanged(qint64)));
    connect(player, SIGNAL(positionChanged(qint64)), this, SLOT(positionChanged(qint64)));
    connect(player, SIGNAL(metaDataChanged()), SLOT(metaDataChanged()));
    connect(playlist, SIGNAL(currentIndexChanged(int)), SLOT(playlistPositionChanged(int)));

    playlistModel = new MediaPlaylistModel(this);
    playlistModel->setPlaylist(playlist);

    playlistView = new QListView(this);
    playlistView->setModel(playlistModel);
    playlistView->setCurrentIndex(playlistModel->index(playlist->currentIndex(), 0));

    connect(playlistView, SIGNAL(activated(QModelIndex)), this, SLOT(jump(QModelIndex)));

    slider = new QSlider(Qt::Horizontal, this);
    slider->setRange(0, player->duration() / 1000);

    labelDuration = new QLabel(this);
    connect(slider, SIGNAL(sliderMoved(int)), this, SLOT(seek(int)));

    MediaControls *controls = new MediaControls(this);
    controls->setState(player->state());
    controls->setVolume(player->volume());
    controls->setMuted(controls->isMuted());

    connect(controls, SIGNAL(play()), player, SLOT(play()));
    connect(controls, SIGNAL(pause()), player, SLOT(pause()));
    connect(controls, SIGNAL(stop()), player, SLOT(stop()));
    connect(controls, SIGNAL(next()), playlist, SLOT(next()));
    connect(controls, SIGNAL(previous()), playlist, SLOT(previous()));
    connect(controls, SIGNAL(changeVolume(int)), player, SLOT(setVolume(int)));
    connect(controls, SIGNAL(changeMuting(bool)), player, SLOT(setMuted(bool)));

    connect(player, SIGNAL(stateChanged(QMediaPlayer::State)), controls, SLOT(setState(QMediaPlayer::State)));
    connect(player, SIGNAL(volumeChanged(int)), controls, SLOT(setVolume(int)));
    connect(player, SIGNAL(mutedChanged(bool)), controls, SLOT(setMuted(bool)));

    trackInfo = new QLabel(this);
    albumInfo = new QLabel(this);
    authorInfo = new QLabel(this);

    menuBar = new QMenuBar(this);
    fileMenu = new QMenu("File...");
    aboutMenu = new QMenu("About");

    fileMenu->addAction("Open file(s)", this, SLOT(open()), Qt::CTRL + Qt::Key_O);

    fileMenu->addSeparator();

    fileMenu->addAction("Exit", qApp, SLOT(quit()), Qt::CTRL + Qt::Key_Q);
    aboutMenu->addAction("About Qt", this, SLOT(aboutQt()), Qt::ALT + Qt::Key_A);

    menuBar->addMenu(fileMenu);
    menuBar->addMenu(aboutMenu);

    menuBar->show();

    QVBoxLayout *mainLayout = new QVBoxLayout;
    QVBoxLayout *mediaInfoLayout = new QVBoxLayout;
    QHBoxLayout *progressLayout = new QHBoxLayout;

    mediaInfoLayout->addWidget(authorInfo);
    mediaInfoLayout->addWidget(albumInfo);
    mediaInfoLayout->addWidget(trackInfo);

    progressLayout->addWidget(slider);
    progressLayout->addWidget(labelDuration);

    mainLayout->addSpacing(10);
    mainLayout->addLayout(mediaInfoLayout);
    mainLayout->addWidget(playlistView);
    mainLayout->addWidget(controls);
    mainLayout->addLayout(progressLayout);

    setLayout(mainLayout);

}

void SamplePlayer::open()
{

    QFileDialog fileDialog(this);
    fileDialog.setAcceptMode(QFileDialog::AcceptOpen);
    QList<QUrl> urls = fileDialog.getOpenFileUrls(0, "Select file(s)", QDir::rootPath(), "MP3 files (*.mp3)");

    foreach (QUrl url, urls) {
        addToPlaylist(url);
    }

}

void SamplePlayer::addToPlaylist(QUrl url) {
    playlist->addMedia(url);
}

void SamplePlayer::jump(const QModelIndex &index)
{
    if (index.isValid()) {
        playlist->setCurrentIndex(index.row());
        player->play();
    }
}

void SamplePlayer::metaDataChanged()
{
    if (player->isMetaDataAvailable()) {
        authorInfo->setText(player->metaData(QMediaMetaData::Author).toString());
        albumInfo->setText(player->metaData(QMediaMetaData::AlbumTitle).toString());
        trackInfo->setText(player->metaData(QMediaMetaData::Title).toString());
    }
}

void SamplePlayer::playlistPositionChanged(int currentItem)
{
    playlistView->setCurrentIndex(playlistModel->index(currentItem, 0));
}

void SamplePlayer::durationChanged(qint64 duration)
{
    this->duration = duration / 1000;
    slider->setMaximum(duration / 1000);
}

void SamplePlayer::seek(int seconds)
{
    player->setPosition(seconds * 1000);
}

void SamplePlayer::updateDurationInfo(qint64 currentInfo)
{
    QString tStr;
    if (currentInfo || duration) {
        QTime currentTime((currentInfo/3600)%60, (currentInfo/60)%60, currentInfo%60, (currentInfo*1000)%1000);
        QTime totalTime((duration/3600)%60, (duration/60)%60, duration%60, (duration*1000)%1000);
        QString format = "mm:ss";
        if (duration > 3600)
            format = "hh:mm:ss";
        tStr = currentTime.toString(format) + " / " + totalTime.toString(format);
    }
    labelDuration->setText(tStr);
}

void SamplePlayer::positionChanged(qint64 progress)
{
    if (!slider->isSliderDown()) {
        slider->setValue(progress / 1000);
    }
    updateDurationInfo(progress / 1000);
}

void SamplePlayer::aboutQt()
{
    QMessageBox::aboutQt(this);
}
