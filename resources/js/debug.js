const isImage = (url) => {
    return /\.(jpg|jpeg|png|webp|avif|gif|svg)$/.test(url);
}

console.log(isImage('jpg/fawinf.jpeg'));