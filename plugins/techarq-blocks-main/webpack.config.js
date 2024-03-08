const fs = require("fs");

// ***************************** */
// Basic JS and SCSS templates
// ***************************** */

const basicJsBlock = (block) => {
  const path = block.split("/");
  const className = path[path.length - 1].replace(".js", "");
  return `import ACFBlock from '../../../assets/js/blocks';

/**
 * Custom ${className} Block, describe your block here.
 */
class ${className}{

    /**
     * Constructor method
     * 
     * @param {HTMLElement} block 
     */
    constructor(block){
        // Your methods init and porps
        console.warn(block)
    }

    /**
     * The name of your block, don't modify this static method!!
     * 
     * @return {string}
     */
    static getName() {
        return '${className}';
    }

    // Your methods
}

new ACFBlock(${className});
    `;
};

const basicScssBlock = (block) => {
  const path = block.split("/");
  const className = path[path.length - 1].replace(".js", "");
  const slashName = className
    .replace(/([a-z])([A-Z])/g, "$1-$2")
    .toLowerCase()
    .replace(".scss", "");
  return `@import '../../../assets/scss/blocks';

.${slashName}{
    // Happy styling!
}
`;
};

const basicPHPBlockRegister = (block) => {
  const spaceName = block.replace(/([a-z])([A-Z])/g, "$1 $2");

  return `<?php
/**
 * Custom ${spaceName} gutenberg block
 *
 * @package TecharqBlocks
 */

namespace TecharqBlocks\\Blocks\\${block};

use TecharqBlocks\\Setup\\AcfBlocks;

/**
 * Block attributes
 */
class ${block} {

\t/**
\t * Block settings
\t */
\tpublic function __construct() {
\t\tacf_register_block_type(
\t\t\tarray_merge(
\t\t\t\tAcfBlocks::block_definitions( get_class( $this ) ),
\t\t\t\tarray(
\t\t\t\t\t'title'       => __( '${spaceName}', 'techarq-blocks' ),
\t\t\t\t\t'description' => __( 'A custom ${spaceName} block.', 'techarq-blocks' ),
\t\t\t\t\t'category'    => 'techarq-blocks',
\t\t\t\t\t'icon'        => 'images-alt2',
\t\t\t\t\t'keywords'    => array( '${spaceName.toLowerCase()}' ),
\t\t\t\t)
\t\t\t)
\t\t);
\t}
}
`;
};

const basicPHPBlockTemplate = (block) => {
  const slashName = block.replace(/([a-z])([A-Z])/g, "$1-$2").toLowerCase();

  return `<div class="${slashName}">
    <!-- Happy code! -->
</div>
    `;
};

// ***************************** */
// Autogenerate Entry Points for webpack (BLOCKS)
// ***************************** */
let entryPoints = {};
const blocks = "./src/Blocks";
const directories = [];

fs.readdirSync(blocks).forEach((dir) => {
    directories.push(dir);
});

directories.forEach((directory) => {
  const entryPoint = {};
  entryPoint[directory] = [
    `${blocks}/${directory}/${directory}.js`,
    `${blocks}/${directory}/${directory}.scss`,
  ];

  entryPoints = {
    ...entryPoints,
    ...entryPoint,
    ...{
      index_techarq_posts: [`./assets/js/index.js`, `./assets/scss/index.scss`],
      techarq_dependencies: [`./assets/js/index.js`, `./assets/scss/techarq-dependencies.scss`]
    }
  };

  // Create PHP file if not exists
  const phpFile = `${blocks}/${directory}/${directory}.php`;
  if (!fs.existsSync(phpFile)) {
    fs.writeFileSync(phpFile, basicPHPBlockRegister(directory));
  }

  // Create PHP template if not exists
  const phpFileTemplate = `${blocks}/${directory}/Template.php`;
  if (!fs.existsSync(phpFileTemplate)) {
    fs.writeFileSync(phpFileTemplate, basicPHPBlockTemplate(directory));
  }
});

for (const entryPoint in entryPoints) {
  const dirs = entryPoints[entryPoint];
  if (entryPoint != "main") {
    dirs.forEach((dir) => {
      if (!fs.existsSync(dir)) {
        if (dir.search("css") != -1) {
          fs.writeFileSync(dir, basicScssBlock(dir));
        } else {
          fs.writeFileSync(dir, basicJsBlock(dir));
        }
      }
    });
  }
}

const currenPath = __dirname;
const three = currenPath.split("/");
const localhost = 'http://' + three[three.indexOf('Local Sites') + 1] + '.local';

// ***************************** */
// Webpack configuration.
// ***************************** */

const path = require("path");
// eslint-disable-next-line no-unused-vars
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");
// eslint-disable-next-line no-unused-vars
const { CleanWebpackPlugin } = require("clean-webpack-plugin");
const TerserPlugin = require("terser-webpack-plugin");
const BrowserSyncPlugin = require("browser-sync-webpack-plugin");

// Live local server proxy
require("dotenv").config();

// JS Directory path.
const JS_DIR = path.resolve(__dirname, "assets/js");

// BUILD Directory path.
const BUILD_DIR = path.resolve(__dirname, "assets/build");

const entry = entryPoints;

const output = {
  path: BUILD_DIR,
  publicPath: "/",
  filename: "[name].min.js",
};

const plugins = (argv) => [
  new CleanWebpackPlugin({
    cleanStaleWebpackAssets: "production" === argv.mode,
  }),

  new MiniCssExtractPlugin({
    filename: "[name].min.css",
  }),

  new BrowserSyncPlugin({
    host: "localhost",
    port: 3000,
    proxy: process.env.LOCAL_SERVER_URL || localhost, // Do not change this value! use .env-webpack to browser sync
    files: ["./**/*"],
    ignore: ["node_modules", "assets/build"],
  }),
];

const rules = [
  {
    test: /\.js$/,
    include: [JS_DIR],
    exclude: /node_modules/,
    use: "babel-loader",
  },
  {
    test: /\.scss$/,
    exclude: /node_modules/,
    use: [
      MiniCssExtractPlugin.loader,
      {
        loader: "css-loader",
        options: {
          url: false,
        },
      },
      "postcss-loader",
      "sass-loader",
    ],
  },
];

module.exports = (env, argv) => ({
  entry: entry,
  output: output,
  devtool: process.argv[3] == "production" ? false : "source-map",

  module: {
    rules: rules,
  },

  devServer: {
    static: true,
  },

  optimization: {
    minimizer: [
      new CssMinimizerPlugin(),
      new TerserPlugin({
        extractComments: false,
      }),
    ],
  },

  plugins: plugins(argv),
  externals: {
    jquery: "jQuery",
  },
  target: "node",
});
