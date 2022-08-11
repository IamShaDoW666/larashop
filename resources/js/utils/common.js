export default function useCommon() {
    const switchTimeFormat = (value, time, time_24) => {
        return value == time ? time_24 : time;
    };

    const isImage = (url) => {
        return /\.(jpg|jpeg|png|webp|avif|gif|svg)$/.test(url);
    };

    const getImagePath = (imagePath, size) => {
        if (isImage(imagePath)) {
            return imagePath;
        } else {
            return imagePath + `_${size}.webp`;
        }
    };

    return { switchTimeFormat, getImagePath };
}
