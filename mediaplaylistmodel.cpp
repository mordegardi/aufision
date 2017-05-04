#include "mediaplaylistmodel.h"

#include <QMediaPlaylist>
#include <QUrl>
#include <QFileInfo>


// The constructor - does nothing
MediaPlaylistModel::MediaPlaylistModel(QObject *parent)
    : QAbstractItemModel(parent)
    , m_playlist(0)
{
}


// returns the count of rows
int MediaPlaylistModel::rowCount(const QModelIndex &parent) const
{
    return m_playlist && !parent.isValid() ? m_playlist->mediaCount() : 0;
}


// returns the count of columns
int MediaPlaylistModel::columnCount(const QModelIndex &parent) const
{
    return !parent.isValid() ? ColumnCount : 0;
}

// returns new index if entry data is right, otherwise returns new empty index
QModelIndex MediaPlaylistModel::index(int row, int column, const QModelIndex &parent) const
{
    return m_playlist && !parent.isValid()
            && row >= 0 && row < m_playlist->mediaCount()
            && column >= 0 && column < ColumnCount
            ? createIndex(row, column)
            : QModelIndex();
}


// returns parent index
QModelIndex MediaPlaylistModel::parent(const QModelIndex &child) const
{
    Q_UNUSED(child);

    return QModelIndex();
}


// if all data is right returns filename of data, otherwise QVariant
QVariant MediaPlaylistModel::data(const QModelIndex &index, int role) const
{
    if (index.isValid() && role == Qt::DisplayRole) {
        QVariant value = m_data[index];
        if (!value.isValid() && index.column() == Title) {

            QUrl location = m_playlist->media(index.row()).canonicalUrl();
            return QFileInfo(location.path()).fileName();

        }

        return value;
    }

    return QVariant();

}


// returns playlist
QMediaPlaylist *MediaPlaylistModel::playlist() const
{
    return m_playlist;
}

// sets data in model, returns true if all ok
bool MediaPlaylistModel::setData(const QModelIndex &index, const QVariant &value, int role)
{
    Q_UNUSED(role);

    m_data[index] = value;
    emit dataChanged(index, index);
    return true;
}

// starts insert items (rows) in playlist
void MediaPlaylistModel::beginInsertItems(int start, int end)
{
    m_data.clear();
    beginInsertRows(QModelIndex(), start, end);
}

// end inserting items (rows) in playlist
void MediaPlaylistModel::endInsertItems()
{
    endInsertRows();
}

// starts removing items (rows) from playlist
void MediaPlaylistModel::beginRemoveItems(int start, int end)
{
    m_data.clear();
    beginRemoveRows(QModelIndex(), start, end);
}

// ends
void MediaPlaylistModel::endRemoveItems()
{
    endRemoveRows();
}

// emit the 'dataChanged()' signal
void MediaPlaylistModel::changeItems(int start, int end)
{
    m_data.clear();
    emit dataChanged(index(start, 0), index(end, ColumnCount));
}

// sets new playlist
void MediaPlaylistModel::setPlaylist(QMediaPlaylist *playlist)
{

    if (m_playlist) {
        disconnect(m_playlist, SIGNAL(mediaAboutToBeInserted(int,int)), this, SLOT(beginInsertItems(int,int)));
        disconnect(m_playlist, SIGNAL(mediaInserted(int,int)), this, SLOT(endInsertItems()));
        disconnect(m_playlist, SIGNAL(mediaAboutToBeRemoved(int,int)), this, SLOT(beginRemoveItems(int,int)));
        disconnect(m_playlist, SIGNAL(mediaRemoved(int,int)), this, SLOT(endRemoveItems()));
        disconnect(m_playlist, SIGNAL(mediaChanged(int,int)), this, SLOT(changeItems(int,int)));
    }

    beginResetModel();
    m_playlist = playlist;

    if (m_playlist) {
        connect(m_playlist, SIGNAL(mediaAboutToBeInserted(int,int)), this, SLOT(beginInsertItems(int,int)));
        connect(m_playlist, SIGNAL(mediaInserted(int,int)), this, SLOT(endInsertItems()));
        connect(m_playlist, SIGNAL(mediaAboutToBeRemoved(int,int)), this, SLOT(beginRemoveItems(int,int)));
        connect(m_playlist, SIGNAL(mediaRemoved(int,int)), this, SLOT(endRemoveItems()));
        connect(m_playlist, SIGNAL(mediaChanged(int,int)), this, SLOT(changeItems(int,int)));
    }

    endResetModel();

}
