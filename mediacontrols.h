#pragma once

#include <QtWidgets>
#include <QMediaPlayer>

class MediaControls : public QWidget
{
    Q_OBJECT

public:
    MediaControls(QWidget *parent = 0);

    QMediaPlayer::State state() const;
    int volume() const;
    bool isMuted();

public slots:
    void setState(QMediaPlayer::State state);
    void setVolume(int volume);
    void setMuted(bool muted);

signals:
    void play();
    void pause();
    void stop();
    void next();
    void previous();
    void changeVolume(int volume);
    void changeMuting(bool muting);
    void valueChanged(int);

private slots:
    void playClicked();
    void muteClicked();
    void onVolumeSliderValueChanged();

private:
    QMediaPlayer::State playerState;
    bool playerMuted;
    QPushButton *playButton;
    QPushButton *stopButton;
    QPushButton *nextButton;
    QPushButton *previousButton;
    QPushButton *muteButton;
    QSlider *volumeSlider;

};
