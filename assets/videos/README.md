# Hero Video Instructions

## Video Options

The hero slider now supports **TWO types of videos**:
1. **Local Video Files** (Slide 4) - MP4/WebM files hosted on your server
2. **YouTube Videos** (Slide 5) - Embedded YouTube videos

Choose the option that works best for you, or use both!

---

## Option 1: Local Video Files

### Video File Setup

1. **Prepare your video file:**
   - Recommended format: MP4 (H.264) for best browser compatibility
   - Optional: WebM format for additional browser support
   - Recommended resolution: 1920x1080 (Full HD)
   - Recommended duration: 10-30 seconds
   - Keep file size under 10MB for optimal loading

2. **Name your video files:**
   - `hero-video.mp4` (required)
   - `hero-video.webm` (optional, for better compression)

3. **Place the video files in:**
   ```
   assets/videos/
   ```

4. **Video will automatically:**
   - Loop continuously
   - Play muted (for autoplay compatibility)
   - Have the same overlay as image slides
   - Display a fallback image if video doesn't load

---

## Option 2: YouTube Video (NEW!)

### YouTube Video Setup

1. **Get your YouTube video ID:**
   - Go to your YouTube video
   - Look at the URL: `https://www.youtube.com/watch?v=YOUR_VIDEO_ID`
   - Copy the video ID (the part after `v=`)
   - Example: If URL is `https://www.youtube.com/watch?v=dQw4w9WgXcQ`
   - Then video ID is: `dQw4w9WgXcQ`

2. **Update the HTML:**
   - Open `index.html`
   - Find the YouTube slide section (around line 160)
   - Replace **BOTH** instances of `YOUR_YOUTUBE_VIDEO_ID` with your actual video ID
   
   ```html
   <!-- Before -->
   src="https://www.youtube.com/embed/YOUR_YOUTUBE_VIDEO_ID?autoplay=1&mute=1&loop=1&playlist=YOUR_YOUTUBE_VIDEO_ID..."
   
   <!-- After (example) -->
   src="https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1&mute=1&loop=1&playlist=dQw4w9WgXcQ..."
   ```

3. **YouTube video will automatically:**
   - Autoplay when slide is active
   - Loop continuously
   - Play muted
   - Have the same overlay as other slides
   - Be responsive and fill the screen

### YouTube Video Best Practices

**Recommended Video Settings:**
- **Privacy:** Set to Public or Unlisted (not Private)
- **Duration:** 30-60 seconds for best engagement
- **Quality:** Upload in 1080p or higher
- **Content:** Showcase your farm, products, or operations

**Video Ideas:**
- Farm tour or drone footage
- Product harvesting and packing
- Time-lapse of farm activities
- Customer testimonials
- Behind-the-scenes operations

### How to Find Your YouTube Video ID

**Method 1: From YouTube URL**
```
https://www.youtube.com/watch?v=dQw4w9WgXcQ
                                 ^^^^^^^^^^^
                                 This is your Video ID
```

**Method 2: From Share Link**
```
https://youtu.be/dQw4w9WgXcQ
                 ^^^^^^^^^^^
                 This is your Video ID
```

**Method 3: From Embed Code**
- Click "Share" on your YouTube video
- Click "Embed"
- Look for: `src="https://www.youtube.com/embed/VIDEO_ID"`

---

## Video Optimization Tips

### For Local Videos - Using FFmpeg (Free Tool)

To optimize your video for web:

```bash
# Convert and compress to MP4
ffmpeg -i input.mp4 -c:v libx264 -crf 28 -preset slow -c:a aac -b:a 128k hero-video.mp4

# Create WebM version (optional)
ffmpeg -i input.mp4 -c:v libvpx-vp9 -crf 30 -b:v 0 -c:a libopus hero-video.webm
```

### Online Tools

If you don't have FFmpeg, use these free online tools:
- **CloudConvert**: https://cloudconvert.com/
- **Online-Convert**: https://www.online-convert.com/
- **HandBrake**: https://handbrake.fr/ (desktop app)

---

## Recommended Video Content

For Royal Albatross Exports, consider videos showing:
- Farm operations and harvesting
- Flower cultivation and cutting
- Packing and quality control processes
- Loading and shipping operations
- Time-lapse of farm activities
- Drone footage of farms and facilities
- Customer testimonials
- Product showcase

---

## Current Setup

**Slide 4:** Local video file (hero-video.mp4)
- Shows fallback image until you add your video

**Slide 5:** YouTube video
- Shows "YOUR_YOUTUBE_VIDEO_ID" placeholder
- Update with your actual video ID

---

## Testing

### For Local Video:
1. Add video file to `assets/videos/`
2. Clear browser cache
3. Reload the website
4. Navigate to slide 4
5. Video should autoplay

### For YouTube Video:
1. Update video ID in `index.html`
2. Save the file
3. Reload the website
4. Navigate to slide 5
5. YouTube video should autoplay

---

## Troubleshooting

### Local Video Issues

**Video not playing?**
- Check file names match exactly: `hero-video.mp4`
- Ensure video is in `assets/videos/` folder
- Try a different browser
- Check browser console for errors
- Verify video codec (H.264 for MP4)

**Video too large?**
- Compress using tools mentioned above
- Reduce resolution to 1280x720
- Shorten duration
- Lower bitrate

### YouTube Video Issues

**YouTube video not showing?**
- Verify video ID is correct
- Check if video is Public or Unlisted (not Private)
- Make sure you replaced BOTH instances of YOUR_YOUTUBE_VIDEO_ID
- Clear browser cache and reload
- Check browser console for errors

**YouTube video not autoplaying?**
- This is normal - browsers require muted autoplay
- Video is already set to mute=1 in the URL
- Some browsers may still block autoplay

**YouTube video shows controls?**
- The embed URL has `controls=0` to hide controls
- This is intentional for a cleaner look
- Users can still click to view on YouTube if needed

---

## Disabling Slides

### To Remove Local Video Slide:
1. Open `index.html`
2. Find and delete the entire `<div class="carousel-item hero-video-slide">` section
3. Update carousel indicators (remove one button)

### To Remove YouTube Video Slide:
1. Open `index.html`
2. Find and delete the entire `<div class="carousel-item hero-youtube-slide">` section
3. Update carousel indicators (remove one button)

---

## Advanced Customization

### Change YouTube Video Parameters

Edit the iframe `src` URL to customize:

```html
?autoplay=1          <!-- Auto-start video -->
&mute=1              <!-- Mute audio -->
&loop=1              <!-- Loop video -->
&playlist=VIDEO_ID   <!-- Required for loop to work -->
&controls=0          <!-- Hide player controls -->
&showinfo=0          <!-- Hide video info -->
&rel=0               <!-- Don't show related videos -->
&modestbranding=1    <!-- Minimal YouTube branding -->
```

**To show controls:** Change `controls=0` to `controls=1`
**To enable sound:** Change `mute=1` to `mute=0` (may prevent autoplay)
**To disable loop:** Remove `&loop=1&playlist=VIDEO_ID`

---

## Need Help?

**Contact:**
- Email: royalalbatrossexports@gmail.com
- Phone: +91 94422 29082

**Resources:**
- YouTube Embed API: https://developers.google.com/youtube/player_parameters
- FFmpeg Documentation: https://ffmpeg.org/documentation.html
- Video Optimization Guide: https://web.dev/fast/#optimize-your-videos

