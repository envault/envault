# Syncing to your local .env

To use the Envault CLI, you must have [Node.js](https://nodejs.org/) installed on your computer.

On your Envault dashboard, you will find a setup command for each app, which you can run to establish a connection to your Envault server, and sync your local .env. This command only needs to be run the first time you connect your .env to Envault. An example setup command:

```
npx envault vault.envault.dev 84632 iCNaGGLou6v0mRas
```

If a .env file is present, your Envault variables will be merged into your existing file. If not, a new .env will be created that contains all variables stored on Envault for that app.

After you've run your app setup command for the first time, you can sync your .env again easily:

```
npx envault
```
