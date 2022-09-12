module.exports = {
	globDirectory: 'public/',
	globPatterns: [
		'**/*.{css,ico,woff,woff2,jpg,webp,png,svg,zip,js,json}'
	],
	swDest: 'public/sw.js',
	ignoreURLParametersMatching: [
		/^utm_/,
		/^fbclid$/
	]
};