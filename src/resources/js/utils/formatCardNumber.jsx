export default function formatCard(e) {
   return e?.match(new RegExp('.{1,4}$|.{1,4}', 'g'))?.join("-");
}