<?php include 'header.php'; ?>
<!-- ============ HERO ============ -->
<section class="hero" id="home">

  <div class="hero-slide is-active" data-index="0">
    <img src="images/entebbe_birding (10).jpg" alt="Hero slide 1" />
    <div class="hero-scrim"></div>
    <div class="hero-content container">
      <span class="hero-tag">— Excursion 01 · Grey Crowned Crane</span>
      <h1 class="hero-title">Bird Watching in Entebbe</h1>
      <p class="hero-sub">Wake with the sunbirds along Lake Victoria's shoreline forests — Uganda's easiest big-list morning, twenty minutes from the airport.</p>
      <div class="hero-btn-row"><a href="#destinations" class="btn btn--gold">View Full Package</a></div>
    </div>
  </div>

  <div class="hero-slide" data-index="1">
    <img src="images/entebbe_birding (20).jpg" alt="Hero slide 2" />
    <div class="hero-scrim"></div>
    <div class="hero-content container">
      <span class="hero-tag">— Excursion 02 · Kibale Forest</span>
      <h1 class="hero-title">Rainforest Bird Encounters</h1>
      <p class="hero-sub">Track turacos, hornbills and rare Albertine Rift endemics through the canopy trails of Kibale, guided by our senior tour guides.</p>
      <div class="hero-btn-row"><a href="#destinations" class="btn btn--gold">View Full Package</a></div>
    </div>
  </div>

  <div class="hero-slide" data-index="2">
    <img src="images/entebbe_birding (30).jpg" alt="Hero slide 3" />
    <div class="hero-scrim"></div>
    <div class="hero-content container">
      <span class="hero-tag">— Excursion 03 · Bwindi Add-On</span>
      <h1 class="hero-title">Birding &amp; Gorilla Trekking</h1>
      <p class="hero-sub">Pair a Bwindi bird list with a mountain gorilla permit — one itinerary, two once-in-a-lifetime encounters.</p>
      <div class="hero-btn-row"><a href="#holiday" class="btn btn--gold">View Full Package</a></div>
    </div>
  </div>

  <button class="hero-arrow hero-arrow--prev" id="heroPrev" aria-label="Previous slide">
    <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
  </button>
  <button class="hero-arrow hero-arrow--next" id="heroNext" aria-label="Next slide">
    <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
  </button>

  <div class="hero-dots" id="heroDots"></div>
</section>

<!-- ============ INTRO BANNER ============ -->
<div class="intro-banner">
  <div class="container">
    <div class="intro-card reveal">
      <span class="eyebrow">Est. Entebbe, Uganda</span>
      <h2>Entebbe Birding Club</h2>
      <p class="tagline">Birdwatching · Bird Encounters · Gorilla Trekking</p>
      <div class="intro-divider"></div>
      <a href="#destinations" class="btn btn--solid">Let's Start Birdwatching</a>
    </div>
  </div>
</div>

<!-- ============ DESTINATIONS ============ -->
<section class="section section--parchment" id="destinations">
  <div class="container">
    <div class="section-head reveal">
      <span class="eyebrow">Field Log · Destinations</span>
      <h2>Where we take our binoculars</h2>
      <p>Four landscapes, four bird communities — from wetland shorelines twenty minutes from Entebbe to primate forest deep in the west.</p>
    </div>

    <div class="dest-grid">

      <article class="dest-card reveal">
        <div class="dest-scope">
          <span class="dest-tag">SHOEBILL COUNTRY</span>
          <img src="images/entebbe_birding (11).jpg" alt="Mabamba Wetland" />
        </div>
        <div class="dest-body">
          <span class="catalog">SPECIES NO. 014 · MABAMBA BAY</span>
          <h3>Mabamba Wetland</h3>
          <p>A papyrus canoe glide across Lake Victoria's edge in search of the prehistoric Shoebill Stork, alongside herons, jacanas and kingfishers.</p>
          <div class="dest-meta"><span>Half-day</span><span>Canoe trip</span><span>Beginner-friendly</span></div>
          <a href="#contact" class="dest-link">Explore More <i class="fa-solid fa-chevron-right" aria-hidden="true"></i></a>
        </div>
      </article>

      <article class="dest-card reveal">
        <div class="dest-scope">
          <span class="dest-tag">LAKESHORE</span>
          <img src="images/entebbe_birding (12).jpg" alt="Lake Victoria" />
        </div>
        <div class="dest-body">
          <span class="catalog">SPECIES NO. 027 · LAKE VICTORIA</span>
          <h3>Entebbe, Lake Victoria</h3>
          <p>Discover the mysterious bird species of the Lake Victoria islands — sunbirds, weavers and fish eagles along the botanical gardens shoreline.</p>
          <div class="dest-meta"><span>Half-day</span><span>Walking</span><span>All levels</span></div>
          <a href="#contact" class="dest-link">Explore More <i class="fa-solid fa-chevron-right" aria-hidden="true"></i></a>
        </div>
      </article>

      <article class="dest-card reveal">
        <div class="dest-scope">
          <span class="dest-tag">RAINFOREST</span>
          <img src="images/entebbe_birding (13).jpg" alt="Kibale Forest" />
        </div>
        <div class="dest-body">
          <span class="catalog">SPECIES NO. 041 · KIBALE FOREST</span>
          <h3>Kibale Forest Birding</h3>
          <p>Chase Albertine Rift endemics and turacos beneath a primate-filled canopy — thirteen species of primate share this same trail system.</p>
          <div class="dest-meta"><span>Full-day</span><span>Forest trail</span><span>Moderate</span></div>
          <a href="#contact" class="dest-link">Explore More <i class="fa-solid fa-chevron-right" aria-hidden="true"></i></a>
        </div>
      </article>

      <article class="dest-card reveal">
        <div class="dest-scope">
          <span class="dest-tag">GORILLA ADD-ON</span>
          <img src="images/entebbe_birding (14).jpg" alt="Bwindi Gorilla Add-On" />
        </div>
        <div class="dest-body">
          <span class="catalog">SPECIES NO. 058 · BWINDI IMPENETRABLE</span>
          <h3>Bwindi Birding + Gorillas</h3>
          <p>Combine a montane bird list — including the elusive African Green Broadbill — with a permitted mountain gorilla trek.</p>
          <div class="dest-meta"><span>3 days</span><span>Trekking</span><span>Permit required</span></div>
          <a href="#contact" class="dest-link">Explore More <i class="fa-solid fa-chevron-right" aria-hidden="true"></i></a>
        </div>
      </article>

    </div>
  </div>
</section>

<!-- ============ ABOUT US ============ -->
<section class="section section--dark" id="about">
  <div class="container">
    <div class="about-wrap">
      <div class="about-copy reveal">
        <span class="eyebrow">About Us</span>
        <h2 style="margin-top:14px;">A community built around the shared pursuit of birds</h2>
        <p style="margin-top:22px;">Entebbe Birding Club (EBC) is a community-based organisation formed to bring bird and nature enthusiasts together to explore, excurse and bird as one. We are a network of passionate birders dedicated to exploring and preserving nature.</p>
        <p>The Club welcomes both seasoned and first-time birders, working toward professional, responsible and ethical tourist guiding for sustainable tourism development in Uganda. On every excursion, our senior tour guides freely share their field expertise with the next generation — students from tertiary institutions across the country.</p>

        <p class="motto">"Bird. Explore. Excursions."</p>

        <p><strong style="color:var(--parchment-100)">Vision.</strong> Communities aware of birds' existence, behaviour, conservation and their environmental habitat.</p>
        <p><strong style="color:var(--parchment-100)">Mission.</strong> Empower tour guides and well-wishers to create community awareness of habitat loss and destruction, and provide guidance toward genuine restoration.</p>
      </div>

      <div class="about-logs reveal">
        <div class="log-card">
          <h4>Our Aims</h4>
          <ul class="log-list">
            <li><span class="log-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg></span>Promote environmental conservation to protect birds through frequent excursions, trainings and explorations countrywide.</li>
          </ul>
        </div>
        <div class="log-card">
          <h4>Our Objectives</h4>
          <ul class="log-list">
            <li><span class="log-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg></span>Involve the young generation in conserving the environment.</li>
            <li><span class="log-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg></span>Eliminate root causes of environmental degradation and secure the home of birds from destruction.</li>
            <li><span class="log-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg></span>Start income-generating projects to sustain Entebbe Birding Club.</li>
            <li><span class="log-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg></span>Train and empower the young generation through exploring, training and excursions.</li>
            <li><span class="log-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg></span>Engage universities, tertiary institutions, government bodies and organisations in conservation.</li>
            <li><span class="log-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg></span>Professionalise tourist guiding and see guides' contributions recognised nationally.</li>
            <li><span class="log-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg></span>Partner with UWA (Uganda Wildlife Authority) for member discounts and park access.</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============ HOLIDAY / PACKAGES ============ -->
<section class="section section--parchment" id="holiday">
  <div class="container">
    <div class="section-head reveal">
      <span class="eyebrow">Holiday Packages</span>
      <h2>Plan your birding holiday</h2>
      <p>From a single sunrise outing to a full-country circuit — every package is guided by an EBC tour guide and built around real bird activity, not a fixed clock.</p>
    </div>

    <div class="pkg-grid">
      <div class="pkg-card reveal">
        <span class="pkg-days">1 DAY</span>
        <h3>Entebbe Weekend Warm-Up</h3>
        <p>A gentle introduction along the Lake Victoria shoreline and botanical gardens — ideal for first-time birders.</p>
        <ul class="pkg-list">
          <li>Sunrise start, guided walk</li>
          <li>Binoculars provided</li>
          <li>Bird checklist included</li>
        </ul>
        <a href="#contact" class="btn btn--outline on-light">Inquire Now</a>
      </div>

      <div class="pkg-card is-featured reveal">
        <span class="pkg-ribbon">Most Booked</span>
        <span class="pkg-days">4 DAYS</span>
        <h3>Mabamba &amp; Kibale Circuit</h3>
        <p>Canoe the papyrus swamps for Shoebill, then head west into Kibale's forest canopy for Albertine Rift endemics.</p>
        <ul class="pkg-list">
          <li>Shoebill canoe excursion</li>
          <li>Kibale forest bird trail</li>
          <li>Senior tour guide throughout</li>
          <li>Accommodation &amp; transfers</li>
        </ul>
        <a href="#contact" class="btn btn--gold">Inquire Now</a>
      </div>

      <div class="pkg-card reveal">
        <span class="pkg-days">7 DAYS</span>
        <h3>Uganda Birding &amp; Gorillas</h3>
        <p>A full-country circuit pairing our best birding sites with a mountain gorilla trekking permit in Bwindi.</p>
        <ul class="pkg-list">
          <li>Mabamba, Kibale &amp; Bwindi</li>
          <li>Gorilla trekking permit assistance</li>
          <li>Full-board accommodation</li>
          <li>Private guide &amp; vehicle</li>
        </ul>
        <a href="#contact" class="btn btn--outline on-light">Inquire Now</a>
      </div>
    </div>
  </div>
</section>

<!-- ============ TEAM ============ -->
<section class="section section--parchment">
  <div class="container">
    <div class="section-head reveal" style="margin-left:auto;margin-right:auto;text-align:center;">
      <span class="eyebrow" style="justify-content:center;">Our Team</span>
      <h2>The guides behind the binoculars</h2>
    </div>

    <div class="team-grid">
      <div class="team-card reveal">
        <div class="team-photo">
          <svg viewBox="0 0 200 200"><rect width="200" height="200" fill="#204329"/><circle cx="100" cy="80" r="38" fill="#e8ece0"/><path d="M50 190 C50 140 140 140 150 190Z" fill="#a63d2f"/></svg>
        </div>
        <h4>David Miiro</h4>
        <span>Director</span>
      </div>
      <div class="team-card reveal">
        <div class="team-photo">
          <svg viewBox="0 0 200 200"><rect width="200" height="200" fill="#345a3b"/><circle cx="100" cy="80" r="38" fill="#f6f1e4"/><path d="M50 190 C50 140 140 140 150 190Z" fill="#16301f"/></svg>
        </div>
        <h4>Claire Nabatanzi</h4>
        <span>Tour Guide</span>
      </div>
      <div class="team-card reveal">
        <div class="team-photo">
          <svg viewBox="0 0 200 200"><rect width="200" height="200" fill="#16301f"/><circle cx="100" cy="80" r="38" fill="#f6f1e4"/><path d="M50 190 C50 140 140 140 150 190Z" fill="#a63d2f"/></svg>
        </div>
        <h4>Claire Nabatanzi</h4>
        <span>Tour Guide</span>
      </div>
    </div>
  </div>
</section>

<!-- ============ PARTNERS ============ -->
<section class="section section--dark">
  <div class="container">
    <div class="section-head reveal" style="margin-left:auto;margin-right:auto;text-align:center;">
      <span class="eyebrow" style="justify-content:center;">Working alongside</span>
      <h2>Our Partners</h2>
    </div>
    <div class="partners-marquee" aria-label="partner logos marquee">
      <div class="partners-track reveal">
        <div class="partner-chip">
          <img src="images/uganda-wildlife-authority-seeklogo.png" alt="Uganda Wildlife Authority logo" />
        </div>
        <div class="partner-chip">
          <img src="images/uganda-tourism-board-logo-png_seeklogo-343626.png" alt="Uganda Tourism Board logo" />
        </div>
        <div class="partner-chip">
          <img src="images/uganda-wildlife-authority-seeklogo.png" alt="Uganda Wildlife Authority logo" />
        </div>
        <div class="partner-chip">
          <img src="images/uganda-tourism-board-logo-png_seeklogo-343626.png" alt="Uganda Tourism Board logo" />
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============ CTA / MEMBERSHIP ============ -->
<section class="cta" id="contact">
  <div class="container cta-inner reveal">
    <div>
      <h2>Become a member of Entebbe Birding Club</h2>
      <p>Join our excursions, learn from senior guides, and help protect the habitats our birds depend on.</p>
    </div>
    <a href="tel:+256778557355" class="btn btn--solid">Call 0778 557 355</a>
  </div>
</section>
<?php include 'footer.php'; ?>