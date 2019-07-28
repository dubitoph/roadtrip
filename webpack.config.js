var Encore = require('@symfony/webpack-encore');

Encore
    .autoProvidejQuery()    

    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "app")
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if you JavaScript imports CSS.
     */
    .addEntry('app', './assets/js/app.js')
    .addEntry('indexAdvert', './assets/js/backend/indexAdvert.js')
    .addEntry('indexEquipment', './assets/js/backend/indexEquipment.js')
    .addEntry('indexSort', './assets/js/backend/indexSort.js')
    .addEntry('indexMark', './assets/js/backend/indexMark.js')
    .addEntry('indexFuel', './assets/js/backend/indexFuel.js')
    .addEntry('indexSeason', './assets/js/backend/indexSeason.js')
    .addEntry('indexDuration', './assets/js/backend/indexDuration.js')
    .addEntry('indexBooking', './assets/js/backend/indexBooking.js')
    .addEntry('indexUser', './assets/js/backend/indexUser.js')
    .addEntry('indexSubscription', './assets/js/backend/indexSubscription.js')
    .addEntry('indexVAT', './assets/js/backend/indexVAT.js')
    .addEntry('indexRating', './assets/js/advert/indexRating.js')
    .addEntry('vehicleManagement', './assets/js/advert/vehicleManagement.js')
    .addEntry('photosManagement', './assets/js/advert/photosManagement.js')
    .addEntry('periodsManagement', './assets/js/advert/periodsManagement.js')
    .addEntry('pricesManagement', './assets/js/advert/pricesManagement.js')
    .addEntry('costsManagement', './assets/js/advert/costsManagement.js')
    .addEntry('bookingManagement', './assets/js/advert/bookingManagement.js')
    .addEntry('ownerManagement', './assets/js/advert/ownerManagement.js')
    .addEntry('ratingManagement', './assets/js/rating/ratingManagement.js')
    .addEntry('showAdvert', './assets/js/advert/showAdvert.js')
    .addEntry('advertsSearch', './assets/js/advert/advertsSearch.js')
    .addEntry('showCalendar', './assets/js/advert/showCalendar.js')
    .addEntry('home', './assets/js/home/home.js')
    .addEntry('payment', './assets/js/payment/payment.js')    
    .addEntry('registration', './assets/js/security/registration.js')    
    .addEntry('threads', './assets/js/communication/threads.js')    
    .addEntry('bookingRequestsManagement', './assets/js/user/bookingRequestsManagement.js')    
    .addEntry('profile', './assets/js/user/profile.js')    
    .addEntry('ownerAdverts', './assets/js/advert/ownerAdverts.js')
    //.addEntry('page2', './assets/js/page2.js')

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // enables Sass/SCSS support
    //.enableSassLoader()

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment if you're having problems with a jQuery plugin
    //.autoProvidejQuery()

    // uncomment if you use API Platform Admin (composer req api-admin)
    //.enableReactPreset()
    //.addEntry('admin', './assets/js/admin.js')

    .addLoader({
        test: /\.(png|jpg|jpeg|gif|ico|svg)$/,
        use: [{
            loader: 'file-loader',
            options: {
                name: '[path][name].[hash:8].[ext]',
                context: './assets',
            }
        }]
    })
;

module.exports = Encore.getWebpackConfig();
