// SPDX-License-Identifier: MIT
pragma solidity ^0.8.20;

/// @title CertificateRegistry
/// @notice Stores only certificate fingerprints on-chain. Full student data and PDF files stay off-chain.
contract CertificateRegistry {
    address public owner;

    mapping(uint256 => bytes32) public certificateHashes;
    mapping(uint256 => uint256) public certificateTimestamps;

    event CertificateRegistered(
        uint256 indexed certId,
        bytes32 indexed certificateHash,
        uint256 timestamp,
        address indexed issuer
    );

    modifier onlyOwner() {
        require(msg.sender == owner, "Only owner can register certificates");
        _;
    }

    constructor() {
        owner = msg.sender;
    }

    function registerCertificate(uint256 certId, bytes32 certificateHash) external onlyOwner {
        require(certId != 0, "Certificate ID is required");
        require(certificateHash != bytes32(0), "Certificate hash is required");
        require(certificateHashes[certId] == bytes32(0), "Certificate already registered");

        certificateHashes[certId] = certificateHash;
        certificateTimestamps[certId] = block.timestamp;

        emit CertificateRegistered(certId, certificateHash, block.timestamp, msg.sender);
    }

    function verifyCertificate(uint256 certId, bytes32 certificateHash) external view returns (bool) {
        return certificateHashes[certId] == certificateHash && certificateHash != bytes32(0);
    }

    function getTimestamp(uint256 certId) external view returns (uint256) {
        return certificateTimestamps[certId];
    }

    function transferOwnership(address newOwner) external onlyOwner {
        require(newOwner != address(0), "New owner is required");
        owner = newOwner;
    }
}
