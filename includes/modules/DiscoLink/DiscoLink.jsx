// External Dependencies
import React, {Component} from 'react';

// Internal Dependencies
import './style.css';


class DiscoLink extends Component {

  static slug = 'disco_link';

  render() {
    const Content = this.props.content;
    const URL = this.props.url;
    const SRC = this.props.src;
    const alt = this.props.alt;

    return (

      <a href={URL}>
        <div className="overlay">
          <div className="title">
            <span className="text">
              <Content/>
            </span>
          </div>
        </div>
        <img src={SRC} alt={alt}/>
      </a>
    );
  }
}

export default DiscoLink;
