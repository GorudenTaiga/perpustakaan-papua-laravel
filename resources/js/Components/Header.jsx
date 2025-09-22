import React from 'react';

export default function Header() {
  return (
    <header className="header">
      <div className="container">
        <div className="row">
          <div className="col-lg-3 col-md-3">
            <div className="header__logo">
              <a href="./index.html">
                <img src="users/images/logo.png" alt="" />
              </a>
            </div>
          </div>
          <div className="col-lg-6 col-md-6">
            <nav className="header__menu mobile-menu">
              <ul>
                <li className="active"><a href="./index.html">Home</a></li>
                <li><a href="./categories.html">Categories</a></li>
                <li><a href="./blog.html">Our Blog</a></li>
                <li><a href="./contact.html">Contacts</a></li>
              </ul>
            </nav>
          </div>
          <div className="col-lg-3 col-md-3">
            <div className="header__nav__option">
              <a href="#" className="search-switch"><img src="users/images/icon/search.png" alt="" /></a>
              <a href="#"><img src="users/images/icon/heart.png" alt="" /></a>
              <a href="#"><img src="users/images/icon/cart.png" alt="" /> <span>0</span></a>
              <div className="price">$0.00</div>
            </div>
          </div>
        </div>
        <div className="canvas__open"><i className="fa fa-bars"></i></div>
      </div>
    </header>
  );
}
