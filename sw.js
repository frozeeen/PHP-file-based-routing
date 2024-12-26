self.addEventListener("install", e => console.log(e, "pwa installed"));
self.addEventListener("fetch", event => {
  // console.log(event, "data fetched");
});
self.addEventListener("activate", event => {
  // Perform activation tasks if needed
  console.log(event, "pwa activated");
});

self.addEventListener("message", function(event) {
  const message = event.data;

  console.log({ message });
});
