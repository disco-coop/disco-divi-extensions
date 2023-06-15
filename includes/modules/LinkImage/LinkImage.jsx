// External Dependencies
import React, { Component } from 'react';

// Internal Dependencies
import './style.css';


class LinkImage extends Component {

  static slug = 'disco_link_image';

  render() {
    const Content = this.props.content;

    return (
      <h1>
        <Content/>
      </h1>
    );
  }
}

export default LinkImage;
