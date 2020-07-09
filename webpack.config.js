var Encore = require('@symfony/webpack-encore');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public_html/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')

    .addEntry('category', './assets/js/category.js')
    .addEntry('toast', './assets/js/toast.ts')
    .addEntry('posting-js', './assets/js/posting.js')

    .addStyleEntry('common', './assets/css/common.scss')
    .addStyleEntry('login-page', './assets/css/login-page.scss')
    .addStyleEntry('posting', './assets/css/posting.scss')
    .addStyleEntry('last-operations', './assets/css/last-operations.scss')

    .splitEntryChunks()

    .enableSingleRuntimeChunk()

    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())

    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })

    .enableSassLoader()
    .enableTypeScriptLoader()
;

module.exports = Encore.getWebpackConfig();
