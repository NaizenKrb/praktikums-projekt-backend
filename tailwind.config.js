/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
      "./resources/**/*.{html,htm,blade.php,js}",
      "./public/**/*.js",
  ],
  theme: {
    extend: {
      colors: {
        "netzfactor": "#004B7C",
        "netzfactor-light": "#0068AD",
        "netzfactor-dark": "#1D4661",
        "web": "#00b0e6",
        "media": "#ce4c34",
        "network": "#08865f",
        "app": "#e8bb40",
      },
      backgroundImage: {
        "split-halfdayMorning": "linear-gradient(to right bottom, #d4d4d4 50% , #f8fafc 50%);",
        "split-halfdayAfternoon": "linear-gradient(to right bottom, #f8fafc 50% , #d4d4d4 50%);",
      }
  },
  safelist: ["bg-app", "bg-network", "bg-media", "bg-web","bg-netzfactor", "bg-netzfactor-light", "bg-netzfactor-dark"],
  plugins: [
    require('@tailwindcss/forms'),
  ],
  }
}
