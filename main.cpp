#include <QApplication>
#include "sampleplayer.h"

int main(int argc, char *argv[])
{
    QApplication app(argc, argv);

    SamplePlayer player;
    player.setWindowTitle("SamplePlayer v0.1.0");
    player.setMinimumSize(QSize(350, 300));
    player.show();

    return app.exec();
}
