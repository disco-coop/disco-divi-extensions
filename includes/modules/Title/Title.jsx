// External Dependencies
import React, { Component } from 'react';

// Internal Dependencies
import './style.css';


class Title extends Component {

  static slug = 'disco_title';

  render() {
    const Content = this.props.content;

    return (
      <h3>
        <Content/>
        <hr/>
      </h3>
    );
  }
}

export default Title;
