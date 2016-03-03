# == Schema Information
#
# Table name: sub_channels
#
#  id                  :integer(4)      not null, primary key
#  sub_channel_type_id :integer(4)
#  subs                :integer(4)
#  outlet_id           :integer(4)
#  created_at          :datetime
#  updated_at          :datetime
#  name                :string(255)
#

require 'test_helper'

class SubChannelTest < ActiveSupport::TestCase
  # test "the truth" do
  #   assert true
  # end
end
