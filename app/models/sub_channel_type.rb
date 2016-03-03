# == Schema Information
#
# Table name: sub_channel_types
#
#  id         :integer(4)      not null, primary key
#  name       :string(255)
#  created_at :datetime
#  updated_at :datetime
#

class SubChannelType < ActiveRecord::Base
	has_many :sub_channels, :dependent => :destroy

	attr_accessible :name
end
