export default function useCommon() {
    const switchTimeFormat = (value, time, time_24) => {
        return value == time ? time_24 : time;
    };

    const isImage = (url) => {
        return /\.(jpg|jpeg|png|webp|avif|gif|svg)$/.test(url);
    };

    const getImagePath = (imagePath) => {
        if (isImage(imagePath)) {
            return imagePath;
        } else {
            return imagePath + "_large.webp";
        }
    };

    return { switchTimeFormat, getImagePath };
}
