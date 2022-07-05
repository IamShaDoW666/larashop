
export default function useCommon() {
    const switchTimeFormat = (value, time, time_24) => {
        return value == time ? time_24 : time;
    };
    return {switchTimeFormat};
}
