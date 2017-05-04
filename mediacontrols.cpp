#include "mediacontrols.h"

#include <QtWidgets>
#include <QtMultimedia>

MediaControls::MediaControls(QWidget *parent)
    : QWidget(parent)
    , playerState(QMediaPlayer::StoppedState)
    , playerMuted(false)
    , playButton(0)
    , stopButton(0)
    , nextButton(0)
    , previousButton(0)
    , muteButton(0)
    , volumeSlider(0)
{

    playButton = new QPushButton(this);
    playButton->setIcon(style()->standardIcon(QStyle::SP_MediaPlay));
    playButton->setFlat(true);

    connect(playButton, SIGNAL(clicked(bool)), SLOT(playClicked()));

    stopButton = new QPushButton(this);
    stopButton->setIcon(style()->standardIcon(QStyle::SP_MediaStop));
    stopButton->setEnabled(false);
    stopButton->setFlat(true);

    connect(stopButton, SIGNAL(clicked(bool)), this, SIGNAL(stop()));

    nextButton = new QPushButton(this);
    nextButton->setIcon(style()->standardIcon(QStyle::SP_MediaSkipForward));
    nextButton->setFlat(true);

    connect(nextButton, SIGNAL(clicked(bool)), this, SIGNAL(next()));

    previousButton = new QPushButton(this);
    previousButton->setIcon(style()->standardIcon(QStyle::SP_MediaSkipBackward));
    previousButton->setFlat(true);

    connect(previousButton, SIGNAL(clicked(bool)), this, SIGNAL(previous()));

    muteButton = new QPushButton(this);
    muteButton->setIcon(style()->standardIcon(QStyle::SP_MediaVolume));
    muteButton->setFlat(true);

    connect(muteButton, SIGNAL(clicked(bool)), this, SLOT(muteClicked()));

    volumeSlider = new QSlider(Qt::Horizontal, this);
    volumeSlider->setRange(0, 100);

    connect(volumeSlider, SIGNAL(valueChanged(int)), this, SLOT(onVolumeSliderValueChanged()));

    QHBoxLayout *hbl = new QHBoxLayout;
    hbl->addWidget(previousButton);
    hbl->addWidget(stopButton);
    hbl->addWidget(playButton);
    hbl->addWidget(nextButton);
    hbl->addWidget(muteButton);
    hbl->addWidget(volumeSlider);

    setLayout(hbl);

}

QMediaPlayer::State MediaControls::state() const
{
    return playerState;
}

void MediaControls::setState(QMediaPlayer::State state)
{

    if (state != playerState) {
        playerState = state;

        switch(state) {
        case QMediaPlayer::StoppedState:
            stopButton->setEnabled(false);
            playButton->setIcon(style()->standardIcon(QStyle::SP_MediaPlay));
            break;
        case QMediaPlayer::PlayingState:
            stopButton->setEnabled(true);
            playButton->setIcon(style()->standardIcon(QStyle::SP_MediaPause));
            break;
        case QMediaPlayer::PausedState:
            stopButton->setEnabled(true);
            playButton->setIcon(style()->standardIcon(QStyle::SP_MediaPlay));
            break;
        }
    }
}

int MediaControls::volume() const
{
    qreal linearVolume = QAudio::convertVolume(volumeSlider->value() / qreal(100),
                                               QAudio::LogarithmicVolumeScale,
                                               QAudio::LinearVolumeScale);

    return qRound(linearVolume * 100);
}

void MediaControls::setVolume(int volume)
{
    qreal logarithmicVolume = QAudio::convertVolume(volume / qreal(100),
                                                    QAudio::LinearVolumeScale,
                                                    QAudio::LogarithmicVolumeScale);

    volumeSlider->setValue(qRound(logarithmicVolume * 100));
}

bool MediaControls::isMuted()
{
    return playerMuted;
}

void MediaControls::setMuted(bool muted)
{
    if (muted != playerMuted) {
        playerMuted = muted;

        muteButton->setIcon(style()->standardIcon(muted
              ? QStyle::SP_MediaVolumeMuted
              : QStyle::SP_MediaVolume));
    }
}

void MediaControls::playClicked()
{
    switch(playerState) {
    case QMediaPlayer::StoppedState:
    case QMediaPlayer::PausedState:
        emit play();
        break;
    case QMediaPlayer::PlayingState:
        emit pause();
        break;
    }
}

void MediaControls::muteClicked()
{
    emit changeMuting(!playerMuted);
}

void MediaControls::onVolumeSliderValueChanged()
{
    emit changeVolume(volume());
}
